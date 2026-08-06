<?php

namespace Modules\PartnerApiManagement\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Jobs\ProcessPushNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Modules\FareManagement\Service\Interfaces\ParcelFareServiceInterface;
use Modules\ParcelManagement\Service\Interfaces\ParcelWeightServiceInterface;
use Modules\PartnerApiManagement\Http\Requests\CreateDeliveryOrderRequest;
use Modules\PartnerApiManagement\Http\Requests\QuoteDeliveryRequest;
use Modules\TripManagement\Lib\CommonTrait;
use Modules\TripManagement\Service\Interfaces\TripRequestServiceInterface;
use Modules\TripManagement\Transformers\TripRequestResource;
use Modules\ZoneManagement\Service\Interfaces\ZoneServiceInterface;

class DeliveryController extends Controller
{
    use CommonTrait;

    public function __construct(
        protected ZoneServiceInterface $zoneService,
        protected ParcelWeightServiceInterface $parcelWeightService,
        protected ParcelFareServiceInterface $parcelFareService,
        protected TripRequestServiceInterface $tripRequestService
    ) {
    }

    /**
     * POST /api/partner/v1/delivery/quote
     * Returns an estimated fare for a delivery between two points.
     */
    public function quote(QuoteDeliveryRequest $request): JsonResponse
    {
        $resolved = $this->resolveQuote($request->all());

        if ($resolved instanceof JsonResponse) {
            return $resolved;
        }

        return response()->json(responseFormatter(DEFAULT_200, $resolved['estimated_fare']));
    }

    /**
     * POST /api/partner/v1/delivery/orders
     * Creates a delivery (parcel) order for the authenticated partner.
     */
    public function store(CreateDeliveryOrderRequest $request): JsonResponse
    {
        $resolved = $this->resolveQuote($request->all());

        if ($resolved instanceof JsonResponse) {
            return $resolved;
        }

        $fare = $resolved['estimated_fare'];
        $zone = $resolved['zone'];
        $routes = $resolved['routes'];

        DB::beginTransaction();
        try {
            $attributes = [
                'customer_id' => auth('api')->id(),
                'zone_id' => $zone->id,
                'area_id' => null,
                'type' => PARCEL,
                'ride_request_type' => null,
                'pickup_coordinates' => $resolved['pickup_point'],
                'destination_coordinates' => $resolved['destination_point'],
                'customer_request_coordinates' => $resolved['pickup_point'],
                'pickup_address' => $request->pickup_address,
                'destination_address' => $request->destination_address,
                'intermediate_coordinates' => json_encode([]),
                'estimated_distance' => $fare['estimated_distance'],
                'estimated_time' => $fare['estimated_duration'],
                'estimated_fare' => $fare['estimated_fare'],
                'actual_fare' => $fare['estimated_fare'],
                'return_fee' => $fare['return_fee'],
                'cancellation_fee' => $fare['cancellation_fee'],
                'extra_fare_fee' => $fare['extra_fare_fee'] ?? 0,
                'extra_fare_amount' => $fare['extra_fare_amount'] ?? 0,
                'surge_multiplier' => $fare['surge_multiplier'] ?? 0,
                'note' => $request->note,
                'pickup_note' => $request->pickup_note,
                'encoded_polyline' => $fare['encoded_polyline'],
                'payer' => $request->payer,
                'weight' => $request->weight,
                'parcel_category_id' => $request->parcel_category_id,
                'sender_name' => $request->sender_name,
                'sender_phone' => $request->sender_phone,
                'sender_address' => $request->sender_address,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'receiver_address' => $request->receiver_address,
            ];

            $trip = $this->tripRequestService->createRideRequest(attributes: $attributes);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Partner delivery order creation failed', ['exception' => $exception->getMessage()]);

            return response()->json(responseFormatter(DEFAULT_FAIL_200), 403);
        }

        $trip = $this->tripRequestService->findOneBy(criteria: ['id' => $trip->id], relations: ['driver.lastLocations', 'time', 'coordinate', 'fee', 'parcel', 'parcelUserInfo', 'parcelRefund']);

        $searchRadius = (double) get_cache('search_radius') ?? 5;
        ProcessPushNotifications::dispatch(radius: $searchRadius, parcelWeight: $request->weight, trip: $trip);

        return response()->json(responseFormatter(TRIP_REQUEST_STORE_200, TripRequestResource::make($trip)));
    }

    /**
     * GET /api/partner/v1/delivery/orders/{id}
     */
    public function show(string $id): JsonResponse
    {
        $trip = $this->tripRequestService->findOneWithAvg(
            criteria: ['id' => $id, 'customer_id' => auth('api')->id()],
            relations: ['driver', 'vehicle.model', 'vehicleCategory', 'tripStatus', 'coordinate', 'fee', 'time', 'parcel', 'parcelUserInfo'],
            withAvgRelation: ['driverReceivedReviews', 'rating']
        );

        if (!$trip) {
            return response()->json(responseFormatter(DEFAULT_404), 403);
        }

        return response()->json(responseFormatter(DEFAULT_200, TripRequestResource::make($trip)));
    }

    /**
     * GET /api/partner/v1/delivery/orders
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->tripRequestService->getBy(
            criteria: ['customer_id' => auth('api')->id(), 'type' => PARCEL],
            relations: ['driver', 'coordinate', 'fee', 'time', 'parcel', 'parcelUserInfo'],
            orderBy: ['created_at' => 'desc'],
            limit: $request->limit ?? 20,
            offset: $request->offset ?? 1
        );

        return response()->json(responseFormatter(constant: DEFAULT_200, content: TripRequestResource::collection($data), limit: $request->limit, offset: $request->offset));
    }

    /**
     * PUT /api/partner/v1/delivery/orders/{id}/cancel
     */
    public function cancel(string $id): JsonResponse
    {
        $trip = $this->tripRequestService->findOneBy(criteria: ['id' => $id, 'customer_id' => auth('api')->id()]);

        if (!$trip) {
            return response()->json(responseFormatter(DEFAULT_404), 403);
        }

        if (!in_array($trip->current_status, [PENDING, ACCEPTED])) {
            return response()->json(responseFormatter(DEFAULT_400), 403);
        }

        $this->tripRequestService->updatedBy(criteria: ['id' => $trip->id], data: ['current_status' => CANCELLED]);
        $trip->tripStatus()->update(['cancelled' => now()]);
        $trip->fee()->update(['cancelled_by' => 'customer']);

        return response()->json(responseFormatter(DEFAULT_200));
    }

    /**
     * Resolves zone, route and fare for the given pickup/destination/parcel
     * information. Returns an array with keys: zone, routes, estimated_fare,
     * pickup_point, destination_point — or a JsonResponse on validation error.
     */
    protected function resolveQuote(array $input): array|JsonResponse
    {
        $pickupCoordinates = $input['pickup_coordinates'];
        $destinationCoordinates = $input['destination_coordinates'];
        $pickupPoint = new Point($pickupCoordinates[0], $pickupCoordinates[1]);
        $destinationPoint = new Point($destinationCoordinates[0], $destinationCoordinates[1]);

        $zone = $this->zoneService->getByPoints($pickupPoint)->where('is_active', 1)->first();
        if (!$zone) {
            return response()->json(responseFormatter(ZONE_404), 403);
        }

        $tripZone = $this->zoneService->getZoneContainingBothPoints($zone->id, $pickupPoint, $destinationPoint);
        if (!$tripZone) {
            return response()->json(responseFormatter(ZONE_404), 403);
        }

        $parcelWeights = $this->parcelWeightService->getBy(limit: 9999, offset: 1);
        $parcelWeight = $parcelWeights->first(function ($item) use ($input) {
            return $input['weight'] >= $item->min_weight && $input['weight'] <= $item->max_weight;
        });
        if (!$parcelWeight) {
            return response()->json(responseFormatter(PARCEL_WEIGHT_400), 403);
        }

        $relations = [
            'fares' => [
                ['parcel_weight_id', '=', $parcelWeight->id],
                ['zone_id', '=', $zone->id],
                ['parcel_category_id', '=', $input['parcel_category_id']],
            ],
            'zone' => [],
        ];
        $whereHasRelations = [
            'fares' => [
                'parcel_weight_id' => $parcelWeight->id,
                'zone_id' => $zone->id,
                'parcel_category_id' => $input['parcel_category_id'],
            ],
        ];
        $tripFare = $this->parcelFareService->findOneBy(criteria: ['zone_id' => $zone->id], whereHasRelations: $whereHasRelations, relations: $relations);
        if (!$tripFare || empty($tripFare->fares)) {
            return response()->json(responseFormatter(PARCEL_WEIGHT_400), 403);
        }

        $routes = getRoutes(
            originCoordinates: $pickupCoordinates,
            destinationCoordinates: $destinationCoordinates,
            intermediateCoordinates: [],
            drivingMode: ['TWO_WHEELER'],
        );
        if (array_key_exists('error', $routes)) {
            return response()->json(responseFormatter(ROUTE_NOT_FOUND_404), 403);
        }

        $estimatedFare = $this->estimatedFare(
            tripRequest: ['type' => PARCEL],
            routes: $routes,
            zone_id: $zone->id,
            zone: $zone,
            tripFare: $tripFare,
            beforeCreate: true
        );

        return [
            'zone' => $zone,
            'routes' => $routes,
            'estimated_fare' => $estimatedFare,
            'pickup_point' => $pickupPoint,
            'destination_point' => $destinationPoint,
        ];
    }
}

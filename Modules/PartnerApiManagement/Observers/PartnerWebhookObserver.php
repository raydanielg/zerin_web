<?php

namespace Modules\PartnerApiManagement\Observers;

use Modules\PartnerApiManagement\Entities\Partner;
use Modules\PartnerApiManagement\Jobs\SendPartnerWebhookJob;
use Modules\TripManagement\Entities\TripRequest;

class PartnerWebhookObserver
{
    /**
     * Fired whenever a trip/parcel request is updated. If the order belongs
     * to a delivery partner (customer_id maps to a partner) and the status
     * actually changed, dispatch a signed webhook to the partner's endpoint.
     */
    public function updated(TripRequest $trip): void
    {
        if ($trip->type !== PARCEL || !$trip->wasChanged('current_status')) {
            return;
        }

        $partner = Partner::query()
            ->where('customer_id', $trip->customer_id)
            ->where('is_active', true)
            ->first();

        if (!$partner || !$partner->webhook_url) {
            return;
        }

        $payload = [
            'event' => 'delivery.status_updated',
            'order_id' => $trip->id,
            'reference' => $trip->ref_id,
            'status' => $trip->current_status,
            'driver_id' => $trip->driver_id,
            'updated_at' => $trip->updated_at?->toIso8601String(),
        ];

        SendPartnerWebhookJob::dispatch($partner->webhook_url, $partner->webhook_secret, $payload);
    }
}

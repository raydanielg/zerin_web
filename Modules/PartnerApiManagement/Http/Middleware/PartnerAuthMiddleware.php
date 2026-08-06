<?php

namespace Modules\PartnerApiManagement\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\PartnerApiManagement\Entities\Partner;

class PartnerAuthMiddleware
{
    /**
     * Authenticates the request using the partner's API key/secret pair and
     * binds the underlying "customer" user to the api auth guard so that
     * the existing trip/parcel services (which rely on auth('api')->id())
     * work transparently for partner requests.
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        $apiSecret = $request->header('X-API-SECRET');

        if (empty($apiKey) || empty($apiSecret)) {
            return response()->json(responseFormatter(DEFAULT_401), 401);
        }

        $partner = Partner::query()->where('api_key', $apiKey)->first();

        if (!$partner || !Hash::check($apiSecret, $partner->api_secret)) {
            return response()->json(responseFormatter(DEFAULT_401), 401);
        }

        if (!$partner->is_active) {
            return response()->json(responseFormatter(DEFAULT_USER_DISABLED_401), 401);
        }

        $customer = $partner->customer;
        if (!$customer || !$customer->is_active) {
            return response()->json(responseFormatter(DEFAULT_USER_DISABLED_401), 401);
        }

        Auth::guard('api')->setUser($customer);
        $request->attributes->set('partner', $partner);

        return $next($request);
    }
}

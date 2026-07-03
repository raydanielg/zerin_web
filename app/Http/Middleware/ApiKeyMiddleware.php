<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (empty($apiKey) || $apiKey !== config('app.integration_api_key')) {
            return response()->json([
                'response_code' => 'UNAUTHORIZED_401',
                'message' => 'Invalid or missing API key',
                'total_size' => null,
                'limit' => null,
                'offset' => null,
                'data' => null,
                'errors' => []
            ], 401);
        }

        return $next($request);
    }
}

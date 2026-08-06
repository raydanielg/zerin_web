<?php

use Illuminate\Support\Facades\Route;
use Modules\PartnerApiManagement\Http\Controllers\Api\DeliveryController;
use Modules\PartnerApiManagement\Http\Middleware\PartnerAuthMiddleware;

Route::group([
    'prefix' => 'partner/v1',
    'middleware' => [PartnerAuthMiddleware::class, 'maintenance_mode'],
], function () {
    Route::group(['prefix' => 'delivery'], function () {
        Route::controller(DeliveryController::class)->group(function () {
            Route::post('quote', 'quote');
            Route::post('orders', 'store');
            Route::get('orders', 'index');
            Route::get('orders/{id}', 'show');
            Route::put('orders/{id}/cancel', 'cancel');
        });
    });
});

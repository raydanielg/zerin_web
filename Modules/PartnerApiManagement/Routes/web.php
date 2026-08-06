<?php

use Illuminate\Support\Facades\Route;
use Modules\PartnerApiManagement\Http\Controllers\Web\Admin\PartnerController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::group(['prefix' => 'partner', 'as' => 'partner.'], function () {
        Route::controller(PartnerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('show/{id}', 'show')->name('show');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('delete/{id}', 'destroy')->name('delete');
            Route::get('status', 'status')->name('status');
            Route::post('regenerate-api-key/{id}', 'regenerateApiKey')->name('regenerate-api-key');
            Route::post('regenerate-webhook-secret/{id}', 'regenerateWebhookSecret')->name('regenerate-webhook-secret');
        });
    });
});

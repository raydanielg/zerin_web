<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RealTimeLocationSharingController;

use Modules\AuthManagement\Http\Controllers\Api\AuthController;
use Modules\BusinessManagement\Http\Controllers\Api\ConfigurationController;
use Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController as CustomerConfigController;
use Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController as DriverConfigController;
use Modules\ChattingManagement\Http\Controllers\Api\ChattingController;
use Modules\ParcelManagement\Http\Controllers\Api\Customer\ParcelCategoryController;
use Modules\ParcelManagement\Http\Controllers\Api\Customer\ParcelController;
use Modules\PromotionManagement\Http\Controllers\Api\Customer\BannerSetupController;
use Modules\PromotionManagement\Http\Controllers\Api\Customer\CouponSetupController;
use Modules\PromotionManagement\Http\Controllers\Api\Customer\DiscountSetupController;
use Modules\ReviewModule\Http\Controllers\Api\ReviewController;
use Modules\TransactionManagement\Http\Controllers\Api\Customer\TransactionController;
use Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController;
use Modules\TripManagement\Http\Controllers\Api\Customer\ParcelRefundController;
use Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController as CustomerSafetyAlertController;
use Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController as CustomerTripController;
use Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController as DriverSafetyAlertController;
use Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController as DriverTripController;
use Modules\TripManagement\Http\Controllers\Api\PaymentController;
use Modules\UserManagement\Http\Controllers\Api\AppNotificationController;
use Modules\UserManagement\Http\Controllers\Api\Customer\AddressController;
use Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController;
use Modules\UserManagement\Http\Controllers\Api\Customer\CustomerLevelController;
use Modules\UserManagement\Http\Controllers\Api\Customer\LoyaltyPointController as CustomerLoyaltyPointController;
use Modules\UserManagement\Http\Controllers\Api\Customer\WalletController;
use Modules\UserManagement\Http\Controllers\Api\Customer\WalletTransferController;
use Modules\UserManagement\Http\Controllers\Api\Driver\DriverActivityController;
use Modules\UserManagement\Http\Controllers\Api\Driver\DriverController;
use Modules\UserManagement\Http\Controllers\Api\Driver\DriverLevelController;
use Modules\UserManagement\Http\Controllers\Api\Driver\IdentityVerificationController;
use Modules\UserManagement\Http\Controllers\Api\Driver\LoyaltyPointController as DriverLoyaltyPointController;
use Modules\UserManagement\Http\Controllers\Api\Driver\TimeTrackController;
use Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawController;
use Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController;
use Modules\UserManagement\Http\Controllers\Api\User\LocationController;
use Modules\VehicleManagement\Http\Controllers\Api\Customer\VehicleCategoryController as CustomerVehicleCategoryController;
use Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleBrandController;
use Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleCategoryController;
use Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleController;
use Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleModelController;
use Modules\ZoneManagement\Http\Controllers\Api\Driver\ZoneController;

/*
|--------------------------------------------------------------------------
| Consolidated Customer & Driver APIs
|--------------------------------------------------------------------------
|
| This file groups all public and authenticated API endpoints used by the
| mobile/customer app and the driver app. It is loaded with the "api"
| middleware group in RouteServiceProvider.
|
*/

// ============================================================
// COMMON / SHARED
// ============================================================

Route::get('track/{token}/data', [RealTimeLocationSharingController::class, 'updatePolyline'])->name('track.data');

Route::controller(ConfigurationController::class)->group(function () {
    Route::get('/configurations', 'getConfiguration');
    Route::get('/get-external-configurations', 'getExternalConfiguration');
    Route::post('/store-configurations', 'updateConfiguration');
});

// ============================================================
// CUSTOMER APIs
// ============================================================

// ---------------- Authentication ----------------
Route::group(['prefix' => 'customer'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('registration', 'register')->name('customer-registration');
            Route::post('registration-from-otp', 'registrationFromOtp');
            Route::post('login', 'login')->name('customer-login');
            Route::post('social-login', 'customerSocialLogin');
            Route::post('update-data', 'updateData');
            Route::post('otp-login', 'otpLogin');
            Route::post('check', 'userExistOrNotChecking');
            Route::post('forget-password', 'forgetPassword');
            Route::post('reset-password', 'resetPassword');
            Route::post('otp-verification', 'otpVerification');
            Route::post('firebase-otp-verification', 'firebaseOtpVerification');
            Route::post('send-otp', 'sendOtp');
            Route::post('external-registration', 'customerRegistrationFromMart');
            Route::post('external-login', 'customerLoginFromMart');
        });
    });

    Route::group(['middleware' => ['auth:api', 'maintenance_mode']], function () {
        Route::group(['prefix' => 'update'], function () {
            Route::put('fcm-token', [AuthController::class, 'updateFcmToken']);
        });

        // Profile
        Route::get('notification-list', [AppNotificationController::class, 'index']);
        Route::controller(CustomerController::class)->group(function () {
            Route::put('update/profile', 'updateProfile');
            Route::get('info', 'profileInfo');
            Route::post('get-data', 'getCustomer');
            Route::post('external-update-data', 'externalUpdateCustomer')->withoutMiddleware('auth:api');
            Route::post('applied-coupon', 'applyCoupon');
            Route::post('change-language', 'changeLanguage');
            Route::get('referral-details', 'referralDetails');
        });

        // Address
        Route::group(['prefix' => 'address'], function () {
            Route::controller(AddressController::class)->group(function () {
                Route::get('all-address', 'getAddresses');
                Route::post('add', 'store');
                Route::get('edit/{id}', 'edit');
                Route::put('update', 'update');
                Route::delete('delete', 'destroy');
            });
        });

        // Wallet
        Route::group(['prefix' => 'wallet'], function () {
            Route::controller(WalletTransferController::class)->group(function () {
                Route::post('transfer-drivemond-to-mart', 'transferDrivemondToMartWallet');
                Route::post('transfer-drivemond-from-mart', 'transferDrivemondFromMartWallet')->withoutMiddleware('auth:api');
            });
            Route::controller(WalletController::class)->group(function () {
                Route::get('bonus-list', 'bonusList');
                Route::get('add-fund-digitally', 'addFundDigitally')->withoutMiddleware('auth:api');
            });
        });

        // Level & Loyalty
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [CustomerLevelController::class, 'getCustomerLevelWithTrip']);
        });
        Route::group(['prefix' => 'loyalty-points'], function () {
            Route::controller(CustomerLoyaltyPointController::class)->group(function () {
                Route::get('list', 'index');
                Route::post('convert', 'convert');
            });
        });

        // Ride / Trip
        Route::get('drivers-near-me', [CustomerTripController::class, 'driversNearMe']);
        Route::group(['prefix' => 'ride'], function () {
            Route::controller(CustomerTripController::class)->group(function () {
                Route::post('get-estimated-fare', 'getEstimatedFare');
                Route::post('create', 'createRideRequest');
                Route::put('ignore-bidding', 'ignoreBidding');
                Route::get('bidding-list/{trip_request_id}', 'biddingList');
                Route::put('update-status/{trip_request_id}', 'rideStatusUpdate');
                Route::get('details/{trip_request_id}', 'rideDetails');
                Route::get('list', 'rideList');
                Route::get('final-fare', 'finalFareCalculation');
                Route::post('trip-action', 'requestAction');
                Route::get('ride-resume-status', 'rideResumeStatus');
                Route::put('arrival-time', 'arrivalTime');
                Route::put('coordinate-arrival', 'coordinateArrival');
                Route::get('ongoing-parcel-list', 'pendingParcelList');
                Route::get('unpaid-parcel-list', 'unpaidParcelRequest');
                Route::put('received-returning-parcel/{trip_request_id}', 'receivedReturningParcel');
                Route::put('edit-scheduled-trip/{trip_request_id}', 'editScheduledTrip');
                Route::get('pending-ride-list', 'pendingRideList');
            });
            Route::post('track-location', [DriverTripController::class, 'trackLocation']);
            Route::get('payment', [PaymentController::class, 'payment']);
            Route::get('digital-payment', [PaymentController::class, 'digitalPayment'])->withoutMiddleware('auth:api');
        });

        // Parcel
        Route::group(['prefix' => 'parcel'], function () {
            Route::controller(ParcelRefundController::class)->group(function () {
                Route::group(['prefix' => 'refund'], function () {
                    Route::post('create', 'createParcelRefundRequest');
                });
            });
            Route::controller(ParcelCategoryController::class)->group(function () {
                Route::get('category', 'categoryFareList');
            });
            Route::controller(ParcelController::class)->group(function () {
                Route::get('vehicle', 'vehicleList');
                Route::get('suggested-vehicle-category', 'suggestedVehicleCategory');
            });
        });

        // Vehicle Category
        Route::group(['prefix' => 'vehicle'], function () {
            Route::group(['prefix' => 'category'], function () {
                Route::controller(CustomerVehicleCategoryController::class)->group(function () {
                    Route::get('/', 'categoryFareList');
                });
            });
        });

        // Review
        Route::group(['prefix' => 'review'], function () {
            Route::controller(ReviewController::class)->group(function () {
                Route::get('list', 'index');
                Route::post('store', 'store');
                Route::put('check-submission', 'checkSubmission');
            });
        });

        // Transaction
        Route::group(['prefix' => 'transaction'], function () {
            Route::controller(TransactionController::class)->group(function () {
                Route::get('list', 'list');
                Route::get('referral-earning-list', 'referralEarningHistory');
            });
        });

        // Chat
        Route::group(['prefix' => 'chat'], function () {
            Route::controller(ChattingController::class)->group(function () {
                Route::get('find-channel', 'findChannel');
                Route::put('create-channel', 'createChannel');
                Route::put('send-message', 'sendMessage');
                Route::get('conversation', 'conversation');
                Route::get('channel-list', 'channelList');
            });
        });

        // Safety Alert
        Route::group(['prefix' => 'safety-alert'], function () {
            Route::controller(CustomerSafetyAlertController::class)->group(function () {
                Route::post('store', 'storeSafetyAlert');
                Route::put('resend/{trip_request_id}', 'resendSafetyAlert');
                Route::put('mark-as-solved/{trip_request_id}', 'markAsSolvedSafetyAlert');
                Route::get('show/{trip_request_id}', 'showSafetyAlert');
                Route::delete('undo/{trip_request_id}', 'deleteSafetyAlert');
            });
        });
    });

    // Public config
    Route::controller(CustomerConfigController::class)->group(function () {
        Route::get('configuration', 'configuration');
        Route::get('pages/{page_name}', 'pages');
        Route::group(['prefix' => 'config'], function () {
            Route::get('get-zone-id', 'getZone');
            Route::get('place-api-autocomplete', 'placeApiAutocomplete');
            Route::get('distance-api', 'distanceApi');
            Route::get('place-api-details', 'placeApiDetails');
            Route::get('geocode-api', 'geocodeApi');
            Route::post('get-routes', 'getRoutes');
            Route::get('get-payment-methods', 'getPaymentMethods');
            Route::get('cancellation-reason-list', 'cancellationReasonList');
            Route::get('parcel-cancellation-reason-list', 'parcelCancellationReasonList');
            Route::get('parcel-refund-reason-list', 'parcelRefundReasonList');
            Route::get('other-emergency-contact-list', 'otherEmergencyContactList');
            Route::get('safety-alert-reason-list', 'safetyAlertReasonList');
            Route::get('safety-precaution-list', 'safetyPrecautionList');
            Route::get('calculate-distance', 'calculateDistance');
        });
    });

    // Banner / Coupon / Discount (some public, some auth)
    Route::group(['prefix' => 'banner'], function () {
        Route::controller(BannerSetupController::class)->group(function () {
            Route::get('list', 'list');
            Route::post('update-redirection-count', 'RedirectionCount');
        });
    });

    Route::group(['prefix' => 'coupon', 'middleware' => ['auth:api', 'maintenance_mode']], function () {
        Route::controller(CouponSetupController::class)->group(function () {
            Route::get('list', 'list');
            Route::post('apply', 'apply');
        });
    });

    Route::group(['prefix' => 'discount', 'middleware' => ['auth:api', 'maintenance_mode']], function () {
        Route::controller(DiscountSetupController::class)->group(function () {
            Route::get('list', 'list');
        });
    });
});

// ============================================================
// DRIVER APIs
// ============================================================

Route::group(['prefix' => 'driver'], function () {

    // Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('registration', 'register')->name('driver-registration');
            Route::post('registration-from-otp', 'registrationFromOtp');
            Route::post('update-data', 'updateData');
            Route::post('login', 'login')->name('driver-login');
            Route::post('send-otp', 'sendOtp');
            Route::post('check', 'userExistOrNotChecking');
            Route::post('forget-password', 'forgetPassword');
            Route::post('reset-password', 'resetPassword');
            Route::post('otp-verification', 'otpVerification');
            Route::post('firebase-otp-verification', 'firebaseOtpVerification');
        });
    });

    Route::group(['middleware' => ['auth:api', 'maintenance_mode']], function () {
        Route::group(['prefix' => 'update'], function () {
            Route::put('fcm-token', [AuthController::class, 'updateFcmToken']);
        });

        // Time tracking & online status
        Route::controller(TimeTrackController::class)->group(function () {
            Route::get('time-tracking', 'store');
            Route::post('update-online-status', 'onlineStatus');
        });

        // Notifications
        Route::get('notification-list', [AppNotificationController::class, 'index']);

        // Profile & Activity
        Route::controller(DriverController::class)->group(function () {
            Route::get('my-activity', 'myActivity');
            Route::post('change-language', 'changeLanguage');
            Route::get('info', 'profileInfo');
            Route::get('income-statement', 'incomeStatement');
            Route::put('update/profile', 'updateProfile');
            Route::get('referral-details', 'referralDetails');
            Route::get('pay-digitally', 'payDigitally')->withoutMiddleware('auth:api');
        });

        Route::group(['prefix' => 'activity'], function () {
            Route::controller(DriverActivityController::class)->group(function () {
                Route::get('leaderboard', 'leaderboard');
                Route::get('daily-income', 'dailyIncome');
            });
        });

        // Level & Loyalty
        Route::group(['prefix' => 'level'], function () {
            Route::controller(DriverLevelController::class)->group(function () {
                Route::get('/', 'getDriverLevelWithTrip');
            });
        });
        Route::group(['prefix' => 'loyalty-points'], function () {
            Route::controller(DriverLoyaltyPointController::class)->group(function () {
                Route::get('list', 'index');
                Route::post('convert', 'convert');
            });
        });

        // Withdraw
        Route::group(['prefix' => 'withdraw'], function () {
            Route::controller(WithdrawController::class)->group(function () {
                Route::get('methods', 'methods');
                Route::post('request', 'create');
                Route::get('pending-request', 'getPendingWithdrawRequests');
                Route::get('settled-request', 'getSettledWithdrawRequests');
            });
        });
        Route::group(['prefix' => 'withdraw-method-info'], function () {
            Route::controller(WithdrawMethodInfoController::class)->group(function () {
                Route::get('list', 'index');
                Route::post('create', 'create');
                Route::get('edit/{id}', 'edit');
                Route::post('update/{id}', 'update');
                Route::post('delete/{id}', 'destroy');
            });
        });

        // Vehicle
        Route::group(['prefix' => 'vehicle'], function () {
            Route::controller(VehicleController::class)->group(function () {
                Route::post('/store', 'store');
                Route::post('/update/{id}', 'update');
            });
            Route::group(['prefix' => 'category'], function () {
                Route::controller(VehicleCategoryController::class)->group(function () {
                    Route::get('/list', 'list');
                });
            });
            Route::group(['prefix' => 'brand'], function () {
                Route::controller(VehicleBrandController::class)->group(function () {
                    Route::get('/list', 'brandList');
                });
            });
            Route::group(['prefix' => 'model'], function () {
                Route::controller(VehicleModelController::class)->group(function () {
                    Route::get('/list', 'modelList');
                });
            });
        });

        // Zone
        Route::group(['prefix' => 'zone'], function () {
            Route::controller(ZoneController::class)->group(function () {
                Route::get('/list', 'list');
            });
        });

        // Ride / Trip
        Route::get('last-ride-details', [DriverTripController::class, 'lastRideDetails']);
        Route::group(['prefix' => 'ride'], function () {
            Route::get('final-fare', [CustomerTripController::class, 'finalFareCalculation']);
            Route::get('payment', [PaymentController::class, 'payment']);

            Route::controller(DriverTripController::class)->group(function () {
                Route::get('show-ride-details', 'showRideDetails');
                Route::get('all-ride-list', 'allRideList');
                Route::put('ride-waiting', 'rideWaiting');
                Route::get('list', 'rideList');
                Route::put('arrival-time', 'arrivalTime');
                Route::put('coordinate-arrival', 'coordinateArrival');
                Route::get('ongoing-parcel-list', 'pendingParcelList');
                Route::get('unpaid-parcel-list', 'unpaidParcelRequest');
                Route::put('resend-otp', 'resendOtp');
                Route::post('match-otp', 'matchOtp');
                Route::post('track-location', 'trackLocation');
                Route::get('details/{ride_request_id}', 'rideDetails');
                Route::get('pending-ride-list', 'pendingRideList');
                Route::put('returned-parcel', 'returnedParcel');
                Route::get('overview', 'tripOverview');
                Route::post('ignore-trip-notification', 'ignoreTripNotification');
                Route::put('update-status', 'rideStatusUpdate');
                Route::post('trip-action', 'requestAction');
                Route::post('bid', 'bid');
                Route::put('update-to-out-for-pickup/{tripId}', 'updateToOutForPickup');
            });
        });

        // Review
        Route::group(['prefix' => 'review'], function () {
            Route::controller(ReviewController::class)->group(function () {
                Route::get('list', 'index');
                Route::post('store', 'store');
                Route::put('save/{id}', 'save');
            });
        });

        // Transaction
        Route::group(['prefix' => 'transaction'], function () {
            Route::controller(DriverTransactionController::class)->group(function () {
                Route::get('list', 'list');
                Route::get('referral-earning-list', 'referralEarningHistory');
                Route::get('payable-list', 'payableTransactionHistory');
                Route::get('cash-collect-list', 'cashCollectTransactionHistory');
                Route::get('wallet-list', 'walletTransactionHistory');
            });
        });

        // Chat
        Route::group(['prefix' => 'chat'], function () {
            Route::controller(ChattingController::class)->group(function () {
                Route::get('find-channel', 'findChannel');
                Route::put('create-channel', 'createChannel');
                Route::put('send-message', 'sendMessage');
                Route::get('conversation', 'conversation');
                Route::get('channel-list', 'channelList');
                Route::put('create-channel-with-admin', 'createChannelWithAdmin');
                Route::put('send-message-to-admin', 'sendMessageToAdminFromDriver');
                Route::put('send-predefined-question-to-admin', 'sendPredefinedQuestionToAdminFromDriver');
            });
        });

        // Safety Alert
        Route::group(['prefix' => 'safety-alert'], function () {
            Route::controller(DriverSafetyAlertController::class)->group(function () {
                Route::post('store', 'storeSafetyAlert');
                Route::put('resend/{trip_request_id}', 'resendSafetyAlert');
                Route::put('mark-as-solved/{trip_request_id}', 'markAsSolvedSafetyAlert');
                Route::get('show/{trip_request_id}', 'showSafetyAlert');
                Route::delete('undo/{trip_request_id}', 'deleteSafetyAlert');
            });
        });

        // Face verification
        Route::group(['prefix' => 'face-verification', 'as' => 'face-verification.'], function () {
            Route::controller(IdentityVerificationController::class)->group(function () {
                Route::get('skip', 'skipVerification');
                Route::post('verify', 'verify');
            });
        });
    });

    // Public driver config
    Route::controller(DriverConfigController::class)->group(function () {
        Route::get('configuration', 'configuration');
        Route::group(['prefix' => 'config'], function () {
            Route::get('get-zone-id', 'getZone');
            Route::get('place-api-autocomplete', 'placeApiAutocomplete');
            Route::get('distance-api', 'distanceApi');
            Route::get('place-api-details', 'placeApiDetails');
            Route::get('geocode-api', 'geocodeApi');
            Route::get('get-payment-methods', 'getPaymentMethods');
            Route::get('cancellation-reason-list', 'cancellationReasonList');
            Route::get('parcel-cancellation-reason-list', 'parcelCancellationReasonList');
            Route::get('predefined-question-answer-list', 'predefinedQuestionAnswerList');
            Route::get('other-emergency-contact-list', 'otherEmergencyContactList');
            Route::get('safety-alert-reason-list', 'safetyAlertReasonList');
            Route::get('safety-precaution-list', 'safetyPrecautionList');
        });
        Route::group(['middleware' => ['auth:api', 'maintenance_mode']], function () {
            Route::post('get-routes', 'getRoutes');
        });
    });
});

// ============================================================
// SHARED USER APIs (auth required)
// ============================================================

Route::group(['prefix' => 'user', 'middleware' => ['auth:api', 'maintenance_mode']], function () {
    Route::controller(LocationController::class)->group(function () {
        Route::post('store-live-location', 'storeLastLocation');
        Route::post('get-live-location', 'getLastLocation');
    });

    Route::controller(AppNotificationController::class)->group(function () {
        Route::put('read-notification', 'readNotification');
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout')->name('logout');
        Route::post('delete', 'delete')->name('delete');
        Route::post('change-password', 'changePassword');
    });

    Route::group(['prefix' => 'location'], function () {
        Route::controller(CustomerConfigController::class)->group(function () {
            Route::post('save', 'userLastLocation');
        });
    });
});

// Screenshot upload (driver)
Route::post('ride/store-screenshot', [DriverTripController::class, 'storeScreenshot'])->middleware('auth:api');

# API Documentation

> Auto-generated from the Laravel route list on **2026-07-03 12:52:23**.  
> Total API endpoints documented: **211**.  
> Base URL: append the `URI` to your application domain. Routes below are registered under the `api` middleware group (no `/api/` prefix is required unless your `RouteServiceProvider` adds it).

## Table of Contents
- [AuthManagement](#authmanagement)
- [BusinessManagement](#businessmanagement)
- [ChattingManagement](#chattingmanagement)
- [Other](#other)
- [ParcelManagement](#parcelmanagement)
- [PromotionManagement](#promotionmanagement)
- [ReviewModule](#reviewmodule)
- [TransactionManagement](#transactionmanagement)
- [TripManagement](#tripmanagement)
- [UserManagement](#usermanagement)
- [VehicleManagement](#vehiclemanagement)
- [ZoneManagement](#zonemanagement)

## AuthManagement

### `POST` `customer/auth/check`

- **Route name:** generated::KS2lJx7n26EqkwLY
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@userExistOrNotChecking`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/external-login`

- **Route name:** generated::Nh9CNj1lHF1UzJqT
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@customerLoginFromMart`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/external-registration`

- **Route name:** generated::HZ9XQBT6Gb3hL9HJ
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@customerRegistrationFromMart`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/firebase-otp-verification`

- **Route name:** generated::KAKns3BIWgzm9ZRq
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@firebaseOtpVerification`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/forget-password`

- **Route name:** generated::6GOcFALlTLnepEeK
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@forgetPassword`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/login`

- **Route name:** customer-login
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@login`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/otp-login`

- **Route name:** generated::sUlK4ZwM8MbTELHs
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@otpLogin`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/otp-verification`

- **Route name:** generated::5rATRKileBa7n9QP
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@otpVerification`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/registration`

- **Route name:** customer-registration
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@register`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/registration-from-otp`

- **Route name:** generated::yuovN3OO6nEEqmLF
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@registrationFromOtp`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/reset-password`

- **Route name:** generated::4KnfTavhVLkkWl43
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@resetPassword`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/send-otp`

- **Route name:** generated::EYP1g9g8Qf6AoXNY
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@sendOtp`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/social-login`

- **Route name:** generated::BLdQ0k0pvwirO4UN
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@customerSocialLogin`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/auth/update-data`

- **Route name:** generated::URRB3UCclZ4DHtRe
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@updateData`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `customer/update/fcm-token`

- **Route name:** generated::Vuv6kHTNdJouc3RZ
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@updateFcmToken`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/check`

- **Route name:** generated::dPRnzvQkV96UqYY5
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@userExistOrNotChecking`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/firebase-otp-verification`

- **Route name:** generated::GNx0K19xXJgBXHDF
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@firebaseOtpVerification`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/forget-password`

- **Route name:** generated::nisvgtKCBwgXkvfy
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@forgetPassword`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/login`

- **Route name:** driver-login
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@login`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/otp-verification`

- **Route name:** generated::qI5DnsVCGsoTiB2R
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@otpVerification`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/registration`

- **Route name:** driver-registration
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@register`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/registration-from-otp`

- **Route name:** generated::3YNekPhcUD5zqSYv
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@registrationFromOtp`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/reset-password`

- **Route name:** generated::g2XqWKSuwobCwwdR
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@resetPassword`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/send-otp`

- **Route name:** generated::vnseCMPNsL4w2u6q
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@sendOtp`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/auth/update-data`

- **Route name:** generated::577kEqcRVzWJDAYS
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@updateData`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/update/fcm-token`

- **Route name:** generated::BnEeNOQtbHgpkTwl
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@updateFcmToken`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `user/change-password`

- **Route name:** generated::RwBihV4uRRHY3QFU
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@changePassword`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `user/delete`

- **Route name:** delete
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@delete`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `user/logout`

- **Route name:** logout
- **Controller:** `Modules\AuthManagement\Http\Controllers\Api\AuthController@logout`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## BusinessManagement

### `GET` `configurations`

- **Route name:** generated::vC7N5RjfzTecAemE
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\ConfigurationController@getConfiguration`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/calculate-distance`

- **Route name:** generated::4rt4clcZ5B3xZD24
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@calculateDistance`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/cancellation-reason-list`

- **Route name:** generated::xtWg3SuxyXCTN6fq
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@cancellationReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/distance-api`

- **Route name:** generated::qz6KhhGZtnzjmscw
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@distanceApi`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/geocode-api`

- **Route name:** generated::0g8JotKOemEMdkg9
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@geocodeApi`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/get-payment-methods`

- **Route name:** generated::eqcuhw9qpZ1ISPKT
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@getPaymentMethods`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/config/get-routes`

- **Route name:** generated::gddUtQl3hSKjaT9S
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@getRoutes`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/config/get-zone-id`

- **Route name:** generated::UFB0wftHNLAmz7T7
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@getZone`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/other-emergency-contact-list`

- **Route name:** generated::KVcSb7g9yyHogCjw
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@otherEmergencyContactList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/parcel-cancellation-reason-list`

- **Route name:** generated::LUzijqOiztTqWqiZ
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@parcelCancellationReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/parcel-refund-reason-list`

- **Route name:** generated::LdPjUXIgW5wepeRp
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@parcelRefundReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/place-api-autocomplete`

- **Route name:** generated::mwNE0ioPT1eATewn
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@placeApiAutocomplete`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/place-api-details`

- **Route name:** generated::2ka0TtdSV1YLHIlR
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@placeApiDetails`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/safety-alert-reason-list`

- **Route name:** generated::3r2Bke8dVsIN4sHq
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@safetyAlertReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/config/safety-precaution-list`

- **Route name:** generated::abLYcCNNtGZ0JLMy
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@safetyPrecautionList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/configuration`

- **Route name:** generated::QWkkZaUHXSPPzk5o
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@configuration`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/pages/{page_name}`

- **Route name:** generated::pLfohYmddmkDUrS1
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@pages`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/cancellation-reason-list`

- **Route name:** generated::nXWLFvhviUaBDydD
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@cancellationReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/distance-api`

- **Route name:** generated::mxoFZvxAPf2gDt8S
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@distanceApi`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/geocode-api`

- **Route name:** generated::Na34EkBG64cHlEzI
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@geocodeApi`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/get-payment-methods`

- **Route name:** generated::jeYXbiZDbFhKjfng
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@getPaymentMethods`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/get-zone-id`

- **Route name:** generated::iGxCypJkniYsh8Ft
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@getZone`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/other-emergency-contact-list`

- **Route name:** generated::2GpPdzvfiNDykZKE
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@otherEmergencyContactList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/parcel-cancellation-reason-list`

- **Route name:** generated::mcB4eAMXPurDMGYR
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@parcelCancellationReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/place-api-autocomplete`

- **Route name:** generated::RDsYe0WGo6KZxNMF
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@placeApiAutocomplete`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/place-api-details`

- **Route name:** generated::llYxIaAbLRR5XJj8
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@placeApiDetails`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/predefined-question-answer-list`

- **Route name:** generated::hrbnqpJdaUspBY6k
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@predefinedQuestionAnswerList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/safety-alert-reason-list`

- **Route name:** generated::gfOOLCYG5YvjLzEp
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@safetyAlertReasonList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/config/safety-precaution-list`

- **Route name:** generated::JGk4SRrkcVfnZPt0
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@safetyPrecautionList`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/configuration`

- **Route name:** generated::WKi9LlzcotjsRRKZ
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@configuration`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/get-routes`

- **Route name:** generated::iEKVQc4ZFCR9Htqy
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Driver\ConfigController@getRoutes`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `get-external-configurations`

- **Route name:** generated::PPZGjnStawx40awQ
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\ConfigurationController@getExternalConfiguration`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `store-configurations`

- **Route name:** generated::lO8XqqEsylAcN9Kb
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\ConfigurationController@updateConfiguration`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `user/location/save`

- **Route name:** generated::FQvJaWZj5H7vaoJC
- **Controller:** `Modules\BusinessManagement\Http\Controllers\Api\Customer\ConfigController@userLastLocation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## ChattingManagement

### `GET` `customer/chat/channel-list`

- **Route name:** generated::caDnyGRENHFs2XYJ
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@channelList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/chat/conversation`

- **Route name:** generated::130TpQz0R0mR9njd
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@conversation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/chat/create-channel`

- **Route name:** generated::e9AcPCIf3usRW2xv
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@createChannel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/chat/find-channel`

- **Route name:** generated::6KNSicv7pbAUUzUu
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@findChannel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/chat/send-message`

- **Route name:** generated::Qw0Ek3R7NFmxZm4g
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@sendMessage`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/chat/channel-list`

- **Route name:** generated::7oAibuPBnZxfo6jA
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@channelList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/chat/conversation`

- **Route name:** generated::lJPlKjxJhoceP7Ik
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@conversation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/chat/create-channel`

- **Route name:** generated::zUeGs7ZhiFQ1cw8u
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@createChannel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/chat/create-channel-with-admin`

- **Route name:** generated::DfxaB9DaveZLFNPn
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@createChannelWithAdmin`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/chat/find-channel`

- **Route name:** generated::lNADNGRWIoaGdbyu
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@findChannel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/chat/send-message`

- **Route name:** generated::ATaDglhZBVsByzkR
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@sendMessage`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/chat/send-message-to-admin`

- **Route name:** generated::QWzWkwWTk8JoD9WZ
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@sendMessageToAdminFromDriver`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/chat/send-predefined-question-to-admin`

- **Route name:** generated::xhJgRKRe4R7Th2bE
- **Controller:** `Modules\ChattingManagement\Http\Controllers\Api\ChattingController@sendPredefinedQuestionToAdminFromDriver`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## Other

### `GET | POST` `broadcasting/auth`

- **Route name:** generated::ql9KEmwRdCiXbA2e
- **Controller:** `\Illuminate\Broadcasting\BroadcastController@authenticate`
- **Middleware:** `auth:api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `track/{token}/data`

- **Route name:** track.data
- **Controller:** `App\Http\Controllers\RealTimeLocationSharingController@updatePolyline`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

## ParcelManagement

### `GET` `customer/parcel/category`

- **Route name:** generated::3gQdui1xshpSDEkG
- **Controller:** `Modules\ParcelManagement\Http\Controllers\Api\Customer\ParcelCategoryController@categoryFareList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/parcel/suggested-vehicle-category`

- **Route name:** generated::iTs3oqyhvTPoPe6y
- **Controller:** `Modules\ParcelManagement\Http\Controllers\Api\Customer\ParcelController@suggestedVehicleCategory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/parcel/vehicle`

- **Route name:** generated::09f7rJsmD42VqLya
- **Controller:** `Modules\ParcelManagement\Http\Controllers\Api\Customer\ParcelController@vehicleList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

## PromotionManagement

### `GET` `customer/banner/list`

- **Route name:** generated::RGiEoKx5psl7woTH
- **Controller:** `Modules\PromotionManagement\Http\Controllers\Api\Customer\BannerSetupController@list`
- **Middleware:** `api`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/banner/update-redirection-count`

- **Route name:** generated::DvTsO4nR5BlPfNWE
- **Controller:** `Modules\PromotionManagement\Http\Controllers\Api\Customer\BannerSetupController@RedirectionCount`
- **Middleware:** `api`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/coupon/apply`

- **Route name:** generated::fHyyLiXJlAjGKdoU
- **Controller:** `Modules\PromotionManagement\Http\Controllers\Api\Customer\CouponSetupController@apply`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/coupon/list`

- **Route name:** generated::mp1KuxyCxtcPoIH7
- **Controller:** `Modules\PromotionManagement\Http\Controllers\Api\Customer\CouponSetupController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/discount/list`

- **Route name:** generated::mXtBO4tVmuypPskm
- **Controller:** `Modules\PromotionManagement\Http\Controllers\Api\Customer\DiscountSetupController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

## ReviewModule

### `PUT` `customer/review/check-submission`

- **Route name:** generated::KeLkPKfF2pnc3plN
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@checkSubmission`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/review/list`

- **Route name:** generated::0ilTwWy36rZKehYq
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/review/store`

- **Route name:** generated::iIDVwxDZ7oMxQgrz
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@store`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/review/list`

- **Route name:** generated::o2mpxOEcawYKhG7I
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/review/save/{id}`

- **Route name:** generated::xknuNIO9G3la3Epv
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@save`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/review/store`

- **Route name:** generated::dTogPD5a2S4bqw7T
- **Controller:** `Modules\ReviewModule\Http\Controllers\Api\ReviewController@store`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## TransactionManagement

### `GET` `customer/transaction/list`

- **Route name:** generated::PFNWHitzFrXJ5veb
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Customer\TransactionController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/transaction/referral-earning-list`

- **Route name:** generated::NW4IkXrnuwUP8ox3
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Customer\TransactionController@referralEarningHistory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/transaction/cash-collect-list`

- **Route name:** generated::yEIY34yrqzpmtiVJ
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController@cashCollectTransactionHistory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/transaction/list`

- **Route name:** generated::qzhX97QKnskccROp
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/transaction/payable-list`

- **Route name:** generated::TYCgSO3iyItPQIMF
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController@payableTransactionHistory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/transaction/referral-earning-list`

- **Route name:** generated::ajdwMcJlQRo2Nk48
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController@referralEarningHistory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/transaction/wallet-list`

- **Route name:** generated::vTxrz24qqSn3675n
- **Controller:** `Modules\TransactionManagement\Http\Controllers\Api\Driver\DriverTransactionController@walletTransactionHistory`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

## TripManagement

### `GET` `customer/drivers-near-me`

- **Route name:** generated::MYTq6v33drkySzdI
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@driversNearMe`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/parcel/refund/create`

- **Route name:** generated::xSdYlRm8UqSwo4O4
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\ParcelRefundController@createParcelRefundRequest`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `customer/ride/arrival-time`

- **Route name:** generated::rgpfP5dr80jA3hq0
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@arrivalTime`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/bidding-list/{trip_request_id}`

- **Route name:** generated::qamQZEFe9pmWVd0j
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@biddingList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/ride/coordinate-arrival`

- **Route name:** generated::S4h5ROUbnUOq8PcI
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@coordinateArrival`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/ride/create`

- **Route name:** generated::oA1JPRRs4ggeDZiX
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@createRideRequest`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/details/{trip_request_id}`

- **Route name:** generated::lB5wWfUqYVLQ3HfF
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@rideDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/ride/digital-payment`

- **Route name:** generated::8MTdXm0QsYOjBXGR
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\PaymentController@digitalPayment`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/ride/edit-scheduled-trip/{trip_request_id}`

- **Route name:** generated::9iTR2QYqHoM8iqmm
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@editScheduledTrip`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/final-fare`

- **Route name:** generated::wvtIL56djQlfOVV9
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@finalFareCalculation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/ride/get-estimated-fare`

- **Route name:** generated::pDZyIuIbSJMZqI5Q
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@getEstimatedFare`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `customer/ride/ignore-bidding`

- **Route name:** generated::7dbr9jflwHyqawoP
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@ignoreBidding`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/list`

- **Route name:** generated::iuVGiatHGr6G1wvU
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@rideList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/ride/ongoing-parcel-list`

- **Route name:** generated::3rDHl9r6WExzLUIA
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@pendingParcelList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/ride/payment`

- **Route name:** generated::Ygm4WnLZYfJXvEiE
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\PaymentController@payment`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/ride/pending-ride-list`

- **Route name:** generated::fKgvEOm49ojB3VLf
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@pendingRideList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/ride/received-returning-parcel/{trip_request_id}`

- **Route name:** generated::cSnVBqsZuzWX72p5
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@receivedReturningParcel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/ride-resume-status`

- **Route name:** generated::4rpJtknT9kHrAxod
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@rideResumeStatus`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/ride/track-location`

- **Route name:** generated::0CkrvQpMRVr44klp
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@trackLocation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/ride/trip-action`

- **Route name:** generated::kYDl5SahDWFlNntD
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@requestAction`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/ride/unpaid-parcel-list`

- **Route name:** generated::pT0EFNKTIsGsPnuG
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@unpaidParcelRequest`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/ride/update-status/{trip_request_id}`

- **Route name:** generated::36VPDO7l0rcXkrg5
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@rideStatusUpdate`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `customer/safety-alert/mark-as-solved/{trip_request_id}`

- **Route name:** generated::B36uBNPA9LGeR90e
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController@markAsSolvedSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `customer/safety-alert/resend/{trip_request_id}`

- **Route name:** generated::uW9FL3NaSmxuhnD8
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController@resendSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/safety-alert/show/{trip_request_id}`

- **Route name:** generated::05MxO0LmLuGirsQD
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController@showSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/safety-alert/store`

- **Route name:** generated::YNuvWi49kv3TBE0i
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController@storeSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `DELETE` `customer/safety-alert/undo/{trip_request_id}`

- **Route name:** generated::W1XA0XLRL76vSIMM
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\SafetyAlertController@deleteSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/last-ride-details`

- **Route name:** generated::kMjSfU5v0o57oSxV
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@lastRideDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/ride/all-ride-list`

- **Route name:** generated::TgqpcOeFrgwpH7BG
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@allRideList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/ride/arrival-time`

- **Route name:** generated::Iq9qou0SGcCWCjIW
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@arrivalTime`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/ride/bid`

- **Route name:** generated::itHSdKFsC2iYFVWc
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@bid`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/ride/coordinate-arrival`

- **Route name:** generated::EXsPG3b7WUx1C9Vz
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@coordinateArrival`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/ride/details/{ride_request_id}`

- **Route name:** generated::PJ77JnP94DSBuARF
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@rideDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/ride/final-fare`

- **Route name:** generated::epzV4ADY4uFMAh4x
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Customer\TripRequestController@finalFareCalculation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/ride/ignore-trip-notification`

- **Route name:** generated::NdRsbixdfRUzINkl
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@ignoreTripNotification`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/ride/list`

- **Route name:** generated::RGRZp1lk45e16tE5
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@rideList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/ride/match-otp`

- **Route name:** generated::y30X6xlOpc4xSBIp
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@matchOtp`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/ride/ongoing-parcel-list`

- **Route name:** generated::Nxx4d4zsIDe5J8ET
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@pendingParcelList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/ride/overview`

- **Route name:** generated::0JSdUjsFTycvFXMC
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@tripOverview`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/ride/payment`

- **Route name:** generated::Wgfr9zVDlFNIaynr
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\PaymentController@payment`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/ride/pending-ride-list`

- **Route name:** generated::9kSr0m17k0CAZ8AW
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@pendingRideList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/ride/resend-otp`

- **Route name:** generated::aPJkUzzft3TlhnKl
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@resendOtp`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/ride/returned-parcel`

- **Route name:** generated::T7L4luCOgQVZRr4F
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@returnedParcel`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/ride/ride-waiting`

- **Route name:** generated::m7zDilhrsgU8axbV
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@rideWaiting`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/ride/show-ride-details`

- **Route name:** generated::JfLY8WfJyCGzVUtO
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@showRideDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/ride/track-location`

- **Route name:** generated::SDAVr0atV5jY4cZB
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@trackLocation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/ride/trip-action`

- **Route name:** generated::SX9n3ppfBbwxWiKj
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@requestAction`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/ride/unpaid-parcel-list`

- **Route name:** generated::T4mKHebUxSbPpG8N
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@unpaidParcelRequest`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `driver/ride/update-status`

- **Route name:** generated::xAPmYtApvhBzqVft
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@rideStatusUpdate`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/ride/update-to-out-for-pickup/{tripId}`

- **Route name:** generated::aBZqq4oMFIFZjxNY
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@updateToOutForPickup`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/safety-alert/mark-as-solved/{trip_request_id}`

- **Route name:** generated::bhnwpPaeqBHzNmXG
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController@markAsSolvedSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/safety-alert/resend/{trip_request_id}`

- **Route name:** generated::Vb4Bzy7biTTstzTV
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController@resendSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/safety-alert/show/{trip_request_id}`

- **Route name:** generated::Lxrp8eQLtk2G4ksq
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController@showSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/safety-alert/store`

- **Route name:** generated::QyC3AB73COnzJPfo
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController@storeSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `DELETE` `driver/safety-alert/undo/{trip_request_id}`

- **Route name:** generated::bMdSFsqJziXwxGnc
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\SafetyAlertController@deleteSafetyAlert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `ride/store-screenshot`

- **Route name:** generated::9m8HlZnPrdxcCn2Y
- **Controller:** `Modules\TripManagement\Http\Controllers\Api\Driver\TripRequestController@storeScreenshot`
- **Middleware:** `api`, `auth:api`

**Payload:** No documented validation found. Check the controller method for request parameters.

## UserManagement

### `POST` `customer/address/add`

- **Route name:** generated::lxxnNNezjBJTbuiK
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\AddressController@store`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/address/all-address`

- **Route name:** generated::QdvK2UOkPXWQz5Nd
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\AddressController@getAddresses`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `DELETE` `customer/address/delete`

- **Route name:** generated::M6snjWvfCiTWe75L
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\AddressController@destroy`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/address/edit/{id}`

- **Route name:** generated::aG2EoEwkhvCXkJR1
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\AddressController@edit`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/address/update`

- **Route name:** generated::RbZtZMWeJnkp5HIh
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\AddressController@update`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/applied-coupon`

- **Route name:** generated::vWgbvRCyy6hWnbba
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@applyCoupon`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/change-language`

- **Route name:** generated::zRmMO1YYWMOJSPVp
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@changeLanguage`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/external-update-data`

- **Route name:** generated::A2RnRxVfgdMcX2aZ
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@externalUpdateCustomer`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/get-data`

- **Route name:** generated::rXexHHc5cBMSRiok
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@getCustomer`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/info`

- **Route name:** generated::UzP9XFNnovi8X5Mb
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@profileInfo`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/level`

- **Route name:** generated::ai8cQ9IOcsiJh95W
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerLevelController@getCustomerLevelWithTrip`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/loyalty-points/convert`

- **Route name:** generated::wwNF1wUrTmVIlN4m
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\LoyaltyPointController@convert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/loyalty-points/list`

- **Route name:** generated::BPLl01ZxzJS4Znb7
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\LoyaltyPointController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/notification-list`

- **Route name:** generated::Fl96DqUV5sSU0r9b
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\AppNotificationController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/referral-details`

- **Route name:** generated::ynxqjHOyF9zGQHHV
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@referralDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `PUT` `customer/update/profile`

- **Route name:** generated::5gVsvMkCuJiuvvCZ
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\CustomerController@updateProfile`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `customer/wallet/add-fund-digitally`

- **Route name:** generated::sT9TkvmcQt6J1Ul7
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\WalletController@addFundDigitally`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `customer/wallet/bonus-list`

- **Route name:** generated::psBk67u7zpAcEByj
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\WalletController@bonusList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `customer/wallet/transfer-drivemond-from-mart`

- **Route name:** generated::Aau7bbDzK9LZlfwK
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\WalletTransferController@transferDrivemondFromMartWallet`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `customer/wallet/transfer-drivemond-to-mart`

- **Route name:** generated::PoKiryCnaxSt98X7
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Customer\WalletTransferController@transferDrivemondToMartWallet`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/activity/daily-income`

- **Route name:** generated::yISMB1xi6skh2fyK
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverActivityController@dailyIncome`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/activity/leaderboard`

- **Route name:** generated::dKtiNWhcNfAAR0HN
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverActivityController@leaderboard`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/change-language`

- **Route name:** generated::QybRTIzU8vqlQocu
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@changeLanguage`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/face-verification/skip`

- **Route name:** face-verification.
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\IdentityVerificationController@skipVerification`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/face-verification/verify`

- **Route name:** face-verification.generated::ek0f6u3yWtnHk0aR
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\IdentityVerificationController@verify`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/income-statement`

- **Route name:** generated::m8yjuR65fRFI9d4g
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@incomeStatement`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/info`

- **Route name:** generated::d4XAxAjN6TGVPKV0
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@profileInfo`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/level`

- **Route name:** generated::492jEyTumhXcAgH6
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverLevelController@getDriverLevelWithTrip`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/loyalty-points/convert`

- **Route name:** generated::X8LnS85Ro5dhxdBo
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\LoyaltyPointController@convert`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/loyalty-points/list`

- **Route name:** generated::W5XzZjLWs1Ium1Te
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\LoyaltyPointController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/my-activity`

- **Route name:** generated::Oe7iFjNlS7p5nkJ2
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@myActivity`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/notification-list`

- **Route name:** generated::flyQvb4rvIkaS84D
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\AppNotificationController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/pay-digitally`

- **Route name:** generated::iUY7Fp9hc8kltSop
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@payDigitally`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/referral-details`

- **Route name:** generated::exVKGa32obIkRaYn
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@referralDetails`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/time-tracking`

- **Route name:** generated::s1YTd2TrZzb3GfQa
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\TimeTrackController@store`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/update-online-status`

- **Route name:** generated::CQ1VKjKDETeKDgsz
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\TimeTrackController@onlineStatus`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `driver/update/profile`

- **Route name:** generated::A1E5UoicqOJgEfOR
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\DriverController@updateProfile`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/withdraw-method-info/create`

- **Route name:** generated::NBIaxYDBBsujU183
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController@create`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/withdraw-method-info/delete/{id}`

- **Route name:** generated::GW7ooCeY3g8VyuG8
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController@destroy`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/withdraw-method-info/edit/{id}`

- **Route name:** generated::SFmEt39LHZ3OSxTh
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController@edit`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/withdraw-method-info/list`

- **Route name:** generated::pjtDjMxpSFL4ZO8p
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController@index`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/withdraw-method-info/update/{id}`

- **Route name:** generated::zE9WaOa1jEpmh5PI
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawMethodInfoController@update`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/withdraw/methods`

- **Route name:** generated::mF82Ji1xqjiS0wyr
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawController@methods`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/withdraw/pending-request`

- **Route name:** generated::mxYdAzAVTckp3DEz
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawController@getPendingWithdrawRequests`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/withdraw/request`

- **Route name:** generated::UT1W1oxADNuIJIsz
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawController@create`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `GET` `driver/withdraw/settled-request`

- **Route name:** generated::g65X2fKeX0vuoIWj
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\Driver\WithdrawController@getSettledWithdrawRequests`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `user/get-live-location`

- **Route name:** generated::VotkPhz0BiZy6Smp
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\User\LocationController@getLastLocation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `PUT` `user/read-notification`

- **Route name:** generated::2MxEqeKhY5zJcDsN
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\AppNotificationController@readNotification`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `user/store-live-location`

- **Route name:** generated::2iriuINLb8HWmugl
- **Controller:** `Modules\UserManagement\Http\Controllers\Api\User\LocationController@storeLastLocation`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## VehicleManagement

### `GET` `customer/vehicle/category`

- **Route name:** generated::uRRGJry6GvknmXz2
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Customer\VehicleCategoryController@categoryFareList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/vehicle/brand/list`

- **Route name:** generated::nxrqvvcdLcQ1SAyI
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleBrandController@brandList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/vehicle/category/list`

- **Route name:** generated::mIQXLRs45ZG1lsQJ
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleCategoryController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `GET` `driver/vehicle/model/list`

- **Route name:** generated::JSVdGXL2xgDrLe9N
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleModelController@modelList`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).

### `POST` `driver/vehicle/store`

- **Route name:** generated::bPeIeQbZzGIpgH6t
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleController@store`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

### `POST` `driver/vehicle/update/{id}`

- **Route name:** generated::XG1H38vzqh6Q7Ttj
- **Controller:** `Modules\VehicleManagement\Http\Controllers\Api\Driver\VehicleController@update`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No documented validation found. Check the controller method for request parameters.

## ZoneManagement

### `GET` `driver/zone/list`

- **Route name:** generated::7d6l49DC4ExI1R62
- **Controller:** `Modules\ZoneManagement\Http\Controllers\Api\Driver\ZoneController@list`
- **Middleware:** `api`, `auth:api`, `maintenance_mode`

**Payload:** No payload required (query parameters may be accepted).


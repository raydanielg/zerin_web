<?php

namespace Modules\PartnerApiManagement\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuoteDeliveryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'pickup_coordinates' => 'required|array|size:2',
            'destination_coordinates' => 'required|array|size:2',
            'pickup_address' => 'required|string',
            'destination_address' => 'required|string',
            'parcel_category_id' => 'required|uuid|exists:parcel_categories,id',
            'weight' => 'required|numeric|min:0',
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                responseFormatter(constant: DEFAULT_400, errors: errorProcessor($validator)),
                403
            )
        );
    }
}

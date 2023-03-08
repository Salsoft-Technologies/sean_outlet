<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DateBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'card_holder_name' => 'required',
            'card_number' => 'required',
            'cvv' => 'required',
            'expiry_date' => 'required',
            'female_id' => 'required',
            'slot_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiJsonResponse(false, '', 422, ['errors' => $validator->errors()]));
    }
}
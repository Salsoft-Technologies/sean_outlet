<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'same:new_password',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiJsonResponse(false, $validator->errors()->first(), 422));
    }
}
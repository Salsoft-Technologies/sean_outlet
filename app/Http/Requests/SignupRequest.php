<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignupRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required',
            'user_name' => 'required|unique:users,user_name',
            'phone_number' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|numeric|gte:18',
            'location' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password',
            'gender' => 'required',
            'about' => 'required',
            'hobbies' => 'required',
            // 'avatar' => 'required',
            // 'status' => 'required',
            'price' => 'numeric|required_if:gender,' . User::FEMALE,
            'bank_id' => 'required_if:gender,' . User::FEMALE,
            'account_number' => 'numeric|required_if:gender,' . User::FEMALE,
            'account_holder_name' => 'required_if:gender,' . User::FEMALE,
        ];
    }

    public function messages()
    {
        return [
            'price.required_if' => 'The :attribute field is required.',
            'bank_id.required_if' => 'Please select a valid bank.',
            'account_number.required_if' => 'Account number is mandatory.',
            'account_holder_name.required_if' => 'Account holder name is required.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiJsonResponse(false, $validator->errors()->first(), 422));
    }
}

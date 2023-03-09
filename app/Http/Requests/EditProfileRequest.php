<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::id(),
            'about' => 'required',
            'hobbies' => 'required',
            'phone_number' => 'required|numeric',
            'age' => 'required|numeric|gte:18',
            'price' => 'numeric|required_if:gender,'.User::FEMALE,
            'profile_image' => 'max:2048|mimes:jpg,png,jpeg',
        ];
    }

    public function messages(){
        return [
            'price.required_if' => 'price is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(apiJsonResponse(false, $validator->errors()->first(), 422));
    }
}
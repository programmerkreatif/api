<?php
namespace App\Http\Requests;

use App\Enums\HttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email|max:50',
            'password'=> 'required',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],HttpStatus::HTTP_BAD_REQUEST));
    }
    public function messages() //OPTIONAL
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not correct'
        ];
    }
}
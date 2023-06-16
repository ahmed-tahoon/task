<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'birthdate.before' => 'The user must be at least 18 years old.',
        ];
    }
}

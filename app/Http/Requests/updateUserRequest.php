<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users|min:3',
            'email' => 'required|email|unique:users',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.unique:users' => 'Username already exist',
            'username.min:3' => 'Username is required',
            'email.required' => 'Email is required',
            'email.email' => 'Input must be an e-mail',
            'email.unique:users' => 'Username already exist',
        ];
    }
}

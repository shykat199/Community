<?php

namespace App\Http\Requests;

use http\Message;
use Illuminate\Foundation\Http\FormRequest;

class AdminLogin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'=>['required','email'],
            'password'=>['required','max:10','min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'=>'Email field is required',
            'password.required'=>'Password field is required',
        ];
    }

}


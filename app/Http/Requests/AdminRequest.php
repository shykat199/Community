<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name'=>['required','max:15'],
            'email'=>['required','email','unique:users'],
            'password'=>['required','max:10','min:8']
        ];
    }

    public function messages(): array
    {
        return[
            'name.required'=>'Please Select Name',
            'email.required'=>'Please Select Email',
            'email.unique'=>'Email Has Already Taken',
            'password.required'=>'Please Select Password',
            'password.max'=>'Password Should Not Be More Then 10 Digit',
            'password.min'=>'Password Should Not Be Less Then 8 Digit',
        ];
    }
}

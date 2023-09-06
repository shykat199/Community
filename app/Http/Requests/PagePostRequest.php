<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagePostRequest extends FormRequest
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
            'photoFile' => [ 'mimes:jpeg,png,jpg,gif,svg', 'max:10048'],
            'videoFile' => [ 'mimes:mp4,mov,jpg,avi,webm,wmv,mkv', 'max:10048'],
        ];
    }

    public function messages(): array
    {
        return [
            'photoFile' => 'Image Should Not More Then 10 Mb',
            'videoFile' => 'Video Size Should Not More Then 10 MB',
        ];
    }
}

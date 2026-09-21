<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Single request used for saving the About Section (singleton).
     */
    public function rules(): array
    {
        return [
            'title'             => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string', 'max:5000'],
            'vision'            => ['nullable', 'string', 'max:5000'],
            'mission'           => ['nullable', 'string', 'max:5000'],
            'history'           => ['nullable', 'string', 'max:10000'],
            'values'            => ['nullable', 'string', 'max:5000'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'remove_image'      => ['nullable', 'boolean'],
            'meta_title'        => ['nullable', 'string', 'max:60'],
            'meta_description'  => ['nullable', 'string', 'max:160'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG or WEBP file.',
            'image.max'   => 'The image must not be larger than 5MB.',
        ];
    }
}

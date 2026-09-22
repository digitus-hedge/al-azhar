<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Single request used for both storing and updating a gallery item.
 */
class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            // Required only when creating (POST); optional when updating
            // (PUT via method spoofing) since an existing file may be kept.
            'media' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,mp4,mov,webm,avi',
                'max:10240', // 10MB
            ],

            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'  => 'Please enter a title for this gallery item.',
            'media.required'  => 'Please upload an image or video.',
            'media.file'      => 'The upload must be a valid file.',
            'media.mimes'     => 'Only JPG, PNG, WEBP, GIF images or MP4, MOV, WEBM, AVI videos are allowed.',
            'media.max'       => 'File must not be larger than 10MB.',
        ];
    }
}

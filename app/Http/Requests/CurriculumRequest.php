<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * File: app/Http/Requests/CurriculumRequest.php
 */
class CurriculumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $curriculumId = $this->route('curriculum')?->id;

        return [
            'title' => [
                'required', 'string', 'max:150',
                Rule::unique('curriculums', 'title')->ignore($curriculumId),
            ],
            'description' => ['required', 'string', 'max:550'],

            // Multiple images — each one validated individually
            'images'   => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            // JSON array of existing image paths the user has removed
            'removed_images' => ['nullable', 'string'],

            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'title',
            'description' => 'short description',
            'images'      => 'images',
            'images.*'    => 'image',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Please enter the curriculum title.',
            'title.max'            => 'Title should be 150 characters or less.',
            'title.unique'         => 'A curriculum with this title already exists.',

            'description.required' => 'Please write a short description.',
            'description.max'      => 'Short description should be 550 characters or less.',

            'images.max'           => 'You can upload at most 10 images.',
            'images.*.image'       => 'Each file must be an image.',
            'images.*.mimes'       => 'Images must be JPG, PNG or WEBP.',
            'images.*.max'         => 'Each image must not be larger than 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
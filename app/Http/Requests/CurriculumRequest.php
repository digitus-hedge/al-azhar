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
                'required', 'string', 'max:255',
                Rule::unique('curriculums', 'title')->ignore($curriculumId),
            ],
            'description' => ['required', 'string'],

            // Image is always optional
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'remove_image' => ['nullable', 'in:0,1'],
            'is_active'    => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'title',
            'description' => 'description',
            'image'       => 'image',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Please enter the curriculum title.',
            'title.unique'         => 'A curriculum with this title already exists.',
            'description.required' => 'Please write the curriculum description.',
            'image.mimes'          => 'Image must be a JPG, PNG or WEBP file.',
            'image.max'            => 'Image must not be larger than 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * File: app/Http/Requests/BlogRequest.php
 */
class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $blogId = $this->route('blog')?->id;

        return [
            'title'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs', 'title')->ignore($blogId),
            ],
            'description'  => ['required', 'string'],
            'published_at' => ['nullable', 'date'],

            // Image is always optional
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'remove_image' => ['nullable', 'in:0,1'],
            'journal_link' => ['nullable', 'url', 'max:2048'],

            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'        => 'title',
            'description'  => 'description',
            'published_at' => 'date & time',
            'image'        => 'image',
            'sort_order'   => 'sort order',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Please enter the blog title.',
            'title.unique'         => 'A blog with this title already exists.',
            'description.required' => 'Please write the blog description.',
            'image.mimes'          => 'Image must be a JPG, PNG or WEBP file.',
            'image.max'            => 'Image must not be larger than 5MB.',
            'published_at.date'    => 'Please enter a valid date & time.',
            'journal_link.url'     => 'Please enter a valid URL (including https://).',
            'journal_link.max'     => 'The URL must not be longer than 2048 characters.',
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active', true),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}

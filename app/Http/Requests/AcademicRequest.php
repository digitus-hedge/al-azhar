<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // When editing, ignore the current record's own name
        $academicId = $this->route('academic')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('academics', 'name')->ignore($academicId),
            ],
            'description' => ['required', 'string'],
            'subtitle'    => ['nullable', 'string', 'max:200'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'level',
            'description' => 'description',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Please select a level.',
            'name.unique'          => 'This level is already added. Edit the existing one instead.',
            'description.required' => 'Please provide a description.',
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
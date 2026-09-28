<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('code')) {
            $this->merge(['code' => strtoupper(trim($this->input('code')))]);
        }
    }

    public function rules(): array
    {
        // Works whether the route gives a SchoolClass model or a plain ID
        $class = $this->route('class');

        return [
            'name' => [
                'required', 'string', 'max:30',
                Rule::unique('classes', 'name')
                    ->ignore($class)
                    ->where(fn ($q) => $q->where('department_id', $this->input('department_id')))
                    ->withoutTrashed(),
            ],
            'code' => [
                'nullable', 'string', 'max:20',
                Rule::unique('classes', 'code')->ignore($class)->withoutTrashed(),
            ],
            'department_id' => [
                'nullable', 'integer',
                Rule::exists('departments', 'id')
                    ->whereNull('deleted_at')
                    ->where('is_active', true),
            ],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Please enter a section name.',
            'name.max'              => 'Section name must not be longer than 30 characters.',
            'name.unique'           => 'A Section with this name already exists in this department.',
            'code.max'              => 'Code must be 20 characters or fewer.',
            'code.unique'           => 'This Section code is already in use.',
            'department_id.integer' => 'Please choose a valid department.',
            'department_id.exists'  => 'The selected department does not exist or is inactive.',
            'sort_order.integer'    => 'Sort order must be a number.',
            'sort_order.min'        => 'Sort order cannot be negative.',
        ];
    }
}
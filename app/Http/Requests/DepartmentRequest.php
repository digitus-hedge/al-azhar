<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    public function rules(): array
    {
        // Works whether the route gives a Department model or a plain ID
        $department = $this->route('department');

        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('departments', 'name')->ignore($department)->withoutTrashed(),
            ],
            'code' => [
                'nullable', 'string', 'max:20',
                Rule::unique('departments', 'code')->ignore($department)->withoutTrashed(),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active'   => ['nullable', 'boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Please enter a department name.',
            'name.max'           => 'Department name must not be longer than 255 characters.',
            'name.unique'        => 'A department with this name already exists.',
            'code.max'           => 'Code must be 20 characters or fewer.',
            'code.unique'        => 'This department code is already in use.',
            'description.max'    => 'Description must be 1000 characters or fewer.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min'     => 'Sort order cannot be negative.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Fixed set of 4 stats: Year of Excellence, Students Enrolled, Faculty Strength, Pass Percentage.
            'items'               => 'required|array|size:4',
            'items.*.value'       => 'required|string|max:10',
            'items.*.label'       => 'required|string|max:45',
            // 'items.*.description' => 'nullable|string|max:45',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Please fill in all 4 stat items.',
            'items.size'     => 'All 4 stats are required.',

            'items.*.value.required' => 'The value field is required for item #:position.',
            'items.*.value.max'      => 'The value cannot exceed 10 characters for item #:position.',

            'items.*.label.required' => 'The label field is required for item #:position.',
            'items.*.label.max'      => 'The label cannot exceed 45 characters for item #:position.',

            // 'items.*.description.required' => 'The description field is required for item #:position.',
            // 'items.*.description.max'      => 'The description cannot exceed 45 characters for item #:position.',
        ];
    }

    public function attributes(): array
    {
        return [
            'items.*.value'       => 'value',
            'items.*.label'       => 'label',
            'items.*.description' => 'description',
        ];
    }
}
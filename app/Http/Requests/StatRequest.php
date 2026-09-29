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
            // Fixed set of 4 stats: Academics, Boarding, Events, Facilities.
            'items'               => 'required|array|size:4',
            'items.*.label'       => 'required|string|in:Academics,Boarding,Events,Facilities',
            'items.*.description' => 'required|string|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Please fill in all 4 stat items.',
            'items.size'     => 'All 4 stats are required.',

            'items.*.label.required' => 'The label is missing for item #:position.',
            'items.*.label.in'       => 'Invalid stat label for item #:position.',

            'items.*.description.required' => 'Please enter a description.',
            'items.*.description.max'      => 'The description cannot exceed 150 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'items.*.label'       => 'label',
            'items.*.description' => 'description',
        ];
    }
}
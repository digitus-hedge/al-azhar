<?php

namespace App\Http\Requests;

use App\Models\HostelApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HostelApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name'  => ['required', 'string', 'max:150'],
            'age'           => ['required', 'integer', 'min:3', 'max:25'],
            'class_id'      => ['required', 'integer', 'exists:classes,id'],
            'gender'        => ['required', Rule::in(array_keys(HostelApplication::GENDERS))],

            'parent_name'   => ['required', 'string', 'max:150'],
            'parent_phone'  => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'parent_email'  => ['nullable', 'email', 'max:150'],

            'address'       => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_name.required' => 'Please enter the student\'s full name.',
            'age.required'          => 'Please enter the student\'s age.',
            'age.min'               => 'Age must be at least 3 years.',
            'age.max'               => 'Age cannot exceed 25 years.',
            'class_id.required'     => 'Please select a class.',
            'class_id.exists'       => 'The selected class is invalid.',
            'gender.required'       => 'Please select a gender.',
            'parent_name.required'  => 'Please enter the parent/guardian\'s name.',
            'parent_phone.required' => 'Please enter a contact phone number.',
            'parent_phone.regex'    => 'Please enter a valid phone number.',
            'parent_email.email'    => 'Please enter a valid email address.',
        ];
    }
}
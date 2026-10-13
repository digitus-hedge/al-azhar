<?php

namespace App\Http\Requests;

use App\Models\AdmissionEnquiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdmissionEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name'    => ['required', 'string', 'max:150'],
            'gender'          => ['required', Rule::in(array_keys(AdmissionEnquiry::GENDERS))],

            'parent_name'     => ['required', 'string', 'max:150'],
            'parent_phone'    => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'parent_email'    => ['nullable', 'email', 'max:191'],

            'state'           => ['required', 'string', 'max:100'],
            'district'        => ['required', 'string', 'max:100'],
            'city'            => ['required', 'string', 'max:100'],

            'grade'           => ['required', Rule::in(AdmissionEnquiry::GRADES)],

            'needs_hostel'    => ['required', 'boolean'],
            'needs_transport' => ['required', 'boolean'],

            'message'         => ['nullable', 'string', 'max:2000'],

            // Honeypot — must be empty.
            'website'         => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_phone.regex'    => 'Please enter a valid phone number.',
            'gender.in'             => 'Please select a valid gender.',
            'grade.in'              => 'Please select a valid grade.',
            'needs_hostel.required' => 'Please choose Yes or No for hostel facility.',
            'needs_transport.required' => 'Please choose Yes or No for transportation.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'needs_hostel'    => $this->filled('needs_hostel') ? (bool) $this->input('needs_hostel') : null,
            'needs_transport' => $this->filled('needs_transport') ? (bool) $this->input('needs_transport') : null,
            'student_name'    => trim((string) $this->input('student_name')),
            'parent_name'     => trim((string) $this->input('parent_name')),
            'state'           => trim((string) $this->input('state')),
            'district'        => trim((string) $this->input('district')),
            'city'            => trim((string) $this->input('city')),
            'parent_email'    => $this->input('parent_email') ? trim((string) $this->input('parent_email')) : null,
        ]);
    }
}
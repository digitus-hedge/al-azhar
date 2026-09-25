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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'student_name' => trim((string) $this->student_name),
            'parent_name'  => trim((string) $this->parent_name),
            'parent_phone' => trim((string) $this->parent_phone),
            'parent_email' => $this->parent_email ? strtolower(trim($this->parent_email)) : null,
            'message'      => $this->message ? trim($this->message) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'min:2', 'max:150'],
            'parent_name'  => ['required', 'string', 'min:2', 'max:150'],
            'parent_phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-()]{10,20}$/'],
            'parent_email' => ['nullable', 'email', 'max:191'],
            'grade'        => ['required', Rule::in(AdmissionEnquiry::GRADES)],
            'needs_hostel' => ['required', 'boolean'],
            'message'      => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_name.required' => "Please enter the student's name.",
            'parent_name.required'  => "Please enter the parent's name.",
            'parent_phone.required' => 'Please enter a mobile / WhatsApp number.',
            'parent_phone.regex'    => 'Please enter a valid mobile number (at least 10 digits).',
            'parent_email.email'    => 'Please enter a valid email address.',
            'grade.required'        => 'Please select the grade.',
            'grade.in'              => 'Please select a grade from the list.',
            'needs_hostel.required' => 'Please choose Yes or No.',
        ];
    }

    /** Only the fields the model should receive (honeypot excluded). */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if ($key === null) {
            $data['needs_hostel'] = (bool) $data['needs_hostel'];
        }

        return $data;
    }
}
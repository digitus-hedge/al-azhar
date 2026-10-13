<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'name'     => ['required', 'string', 'max:150'],
            'phone'    => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'comment'  => ['nullable', 'string', 'max:2000'],

            // Honeypot — must be empty
            'website'  => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'    => trim((string) $this->input('name')),
            'phone'   => trim((string) $this->input('phone')),
            'comment' => $this->input('comment') ? trim((string) $this->input('comment')) : null,
        ]);
    }
}
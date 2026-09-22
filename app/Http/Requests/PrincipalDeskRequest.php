<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrincipalDeskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    /**
     * Get the validation rules that apply to the request.
     * Used for both store and update.
     */
    public function rules(): array
    {
        return [
            'heading'         => ['required', 'string', 'max:255'],
            'name'            => ['required', 'string', 'max:255'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'avatar_initial'  => ['nullable', 'string', 'max:2'],
            'excerpt'         => ['required', 'string', 'max:500'],
            'message'         => ['nullable', 'string'],
            'is_active'       => ['nullable', 'boolean'],
            'sort_order'      => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Custom attribute names for nicer error messages.
     */
    public function attributes(): array
    {
        return [
            'heading' => 'heading',
            'excerpt' => 'short excerpt',
            'message' => 'full message',
        ];
    }
}

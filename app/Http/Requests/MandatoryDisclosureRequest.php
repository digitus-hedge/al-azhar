<?php

namespace App\Http\Requests;

use App\Models\MandatoryDisclosure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Used for both creating and updating a disclosure document.
 */
class MandatoryDisclosureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            // 'category'    => ['required', Rule::in(array_keys(MandatoryDisclosure::CATEGORIES))],

            // Required when creating (POST); optional when updating (PUT) — keeps the current PDF.
            'file'        => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'file', 'mimes:pdf', 'max:10240',
            ],

            'issued_by'   => ['nullable', 'string', 'max:255'],
            'issue_date'  => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'             => 'Please enter the document title.',
            // 'category.required'          => 'Please choose a category.',
            // 'category.in'                => 'Please choose a valid category.',
            'file.required'              => 'Please upload the PDF document.',
            'file.mimes'                 => 'The document must be a PDF file.',
            'file.max'                   => 'The PDF must not be larger than 10MB.',
            'issue_date.date'            => 'Please enter a valid issue date.',
            'valid_until.date'           => 'Please enter a valid expiry date.',
            'valid_until.after_or_equal' => 'Valid Until must be on or after the Issue Date.',
            'sort_order.integer'         => 'Display order must be a number.',
        ];
    }
}

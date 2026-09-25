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
        // On edit: the category already saved on this document (null on create).
        $currentCategory = $this->currentDisclosure()?->category;

        return [
            'title'    => ['required', 'string', 'max:255'],

            // Must be an id from disclosure_categories that is not deleted.
            // Exception: on edit, the document's current category is allowed even if it
            // was deleted later, so the document can still be saved without changing it.
            'category' => [
                'required',
                'integer',
                Rule::exists('disclosure_categories', 'id')->where(function ($q) use ($currentCategory) {
                    $q->where(function ($w) use ($currentCategory) {
                        $w->whereNull('deleted_at');
                        if ($currentCategory) {
                            $w->orWhere('id', $currentCategory);
                        }
                    });
                }),
            ],

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
            'category.required'          => 'Please choose a category.',
            'category.integer'           => 'Please choose a valid category.',
            'category.exists'            => 'The selected category no longer exists. Please choose another.',
            'file.required'              => 'Please upload the PDF document.',
            'file.mimes'                 => 'The document must be a PDF file.',
            'file.max'                   => 'The PDF must not be larger than 10MB.',
            'issue_date.date'            => 'Please enter a valid issue date.',
            'valid_until.date'           => 'Please enter a valid expiry date.',
            'valid_until.after_or_equal' => 'Valid Until must be on or after the Issue Date.',
            'sort_order.integer'         => 'Display order must be a number.',
        ];
    }

    /**
     * The document being edited, whatever the route parameter is named
     * ({disclosure}, {mandatoryDisclosure}, {mandatory_disclosure}, ...). Null on create.
     */
    protected function currentDisclosure(): ?MandatoryDisclosure
    {
        return collect($this->route()?->parameters() ?? [])
            ->first(fn ($param) => $param instanceof MandatoryDisclosure);
    }
}
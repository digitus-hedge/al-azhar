<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisclosureCategoryRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Trim and collapse double spaces so "Fire  Safety " == "Fire Safety"
        $this->merge([
            'name' => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
        ]);
    }

    public function rules(): array
    {
        $category = $this->route('category'); // null on create

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:35',
                // Unique among NON-deleted rows, ignoring the row being edited
                Rule::unique('disclosure_categories', 'name')
                    ->ignore($category?->id)
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a category name.',
            'name.min'      => 'Category name must be at least 2 characters.',
            'name.max'      => 'Category name may not be longer than 35 characters.',
            'name.unique'   => 'A category with this name already exists.',
        ];
    }

    public function attributes(): array
    {
        return ['name' => 'category name'];
    }
}

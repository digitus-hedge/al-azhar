<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $feeId = $this->route('fee')?->id;

        return [
            'class_name'   => ['required', 'string', 'max:50', Rule::unique('fees', 'class_name')->ignore($feeId)],
            'fee_amount'   => 'required|numeric|min:0|max:9999999',
            'installments' => 'required|integer|min:1|max:12',
            'sort_order'   => 'nullable|integer|min:0',
            'is_active'    => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'class_name.required'   => 'Please enter the class name.',
            'class_name.unique'     => 'Fees for this class already exist.',
            'fee_amount.required'   => 'Please enter the fee amount.',
            'fee_amount.numeric'    => 'Fee amount must be a number.',
            'installments.required' => 'Please enter the number of instalments.',
            'installments.min'      => 'There must be at least 1 instalment.',
        ];
    }
}
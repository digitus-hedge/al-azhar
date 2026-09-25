<?php

namespace App\Http\Requests;

use App\Models\ManagementDesignation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ManagementDesignationRequest extends FormRequest
{
    public function authorize(): bool
    {
           return true;
    }

    protected function prepareForValidation(): void
    {
        // Trim and collapse double spaces so "Vice  Chairman " == "Vice Chairman"
        $this->merge([
            'name' => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
            'type' => strtolower(trim((string) $this->input('type'))),
        ]);
    }

    public function rules(): array
    {
        $designation = $this->route('designation'); // null on create

        return [
            // Management → School Management form, Staff → Staff form
            'type' => [
                'required',
                Rule::in(array_keys(ManagementDesignation::TYPES)),
            ],

            'name' => [
                'required',
                'string',
                'min:2',
                'max:150',
                // Unique within the SAME type among non-deleted rows, ignoring the row being edited.
                // So "Principal" can exist once as Management and once as Staff.
                Rule::unique('management_designations', 'name')
                    ->where('type', $this->input('type'))
                    ->whereNull('deleted_at')
                    ->ignore($designation?->id),
            ],
        ];
    }

    /**
     * Extra check on edit: the type can't be changed while the designation is in use,
     * otherwise profiles/staff would point to a designation of the wrong type.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $designation = $this->route('designation');

                if ($designation instanceof ManagementDesignation
                    && $designation->type !== $this->input('type')
                    && $designation->isInUse()) {
                    $validator->errors()->add(
                        'type',
                        'Type can\'t be changed because this designation is already used by '
                        . ($designation->type === 'staff' ? 'staff members.' : 'School Management profiles.')
                    );
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please choose Management or Staff.',
            'type.in'       => 'Please choose a valid designation type.',
            'name.required' => 'Please enter a designation name.',
            'name.min'      => 'Designation name must be at least 2 characters.',
            'name.max'      => 'Designation name may not be longer than 150 characters.',
            'name.unique'   => 'This designation already exists for the selected type.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'designation name',
            'type' => 'designation type',
        ];
    }
}
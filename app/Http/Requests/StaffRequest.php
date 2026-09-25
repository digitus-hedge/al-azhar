<?php

namespace App\Http\Requests;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Single request used for both storing and updating a staff member
 * (replaces StoreStaffRequest + UpdateStaffRequest).
 */
class StaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Route parameter is {staffMember} per routes/web.php; null on create.
        $currentStaffMember = $this->route('staffMember');
        $currentStaffId     = $currentStaffMember?->id;
        $currentUserId      = $currentStaffMember?->user_id;
        $currentDesignation = $currentStaffMember?->designation_id;

        return [
            'name'             => ['required', 'string', 'max:255'],
            // Staff designation from Master > Designations (type = staff).
            // On edit the current one stays valid even if it was deleted later.
            'designation_id'   => [
                'required',
                'integer',
                Rule::exists('management_designations', 'id')->where(function ($q) use ($currentDesignation) {
                    $q->where(function ($w) use ($currentDesignation) {
                        $w->where(fn ($x) => $x->whereNull('deleted_at')->where('type', 'staff'));
                        if ($currentDesignation) {
                            $w->orWhere('id', $currentDesignation);
                        }
                    });
                }),
            ],
            'department_id'    => ['nullable', 'exists:departments,id'],
            'class_id'         => ['nullable', 'exists:classes,id'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'show_on_home'     => ['nullable', 'boolean'],

            // Required only when creating (POST); optional when updating
            // (PUT via method spoofing) since an existing photo may be kept.
            'photo' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'is_head_of_staff' => [
                'nullable',
                'boolean',
                function ($attribute, $value, $fail) use ($currentStaffId) {
                    // Only enforce "one head of staff per department" when
                    // this field is actually being turned on.
                    if (! $value) {
                        return;
                    }

                    $departmentId = $this->input('department_id');

                    if (! $departmentId) {
                        return; // department_id's own "required" rule already fails this request
                    }

                    $alreadyHasHead = Staff::where('department_id', $departmentId)
                        ->where('is_head_of_staff', true)
                        ->when($currentStaffId, fn($q) => $q->where('id', '!=', $currentStaffId))
                        ->exists();

                    if ($alreadyHasHead) {
                        $fail('This department already has a Head of Staff. Remove that designation from the existing head of staff first, then assign it here.');
                    }
                },
            ],

            // Login Access — only matters while "has_login" is turned on.
            'has_login' => ['nullable', 'boolean'],

            'login_email' => [
                'nullable',
                'required_if:has_login,1',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($currentUserId),
            ],

            'login_password' => [
                'nullable',
                // Required when login is ON and no account exists yet.
                // When editing a staff member who already has a login, blank = keep current password.
                Rule::requiredIf(fn() => $this->boolean('has_login') && ! $currentUserId),
                'string',
                'min:8',
            ],



            // Role + module permissions — only meaningful while "has_login" is on.
            'login_role' => ['nullable', Rule::in(['admin', 'staff'])],

            'login_permissions'   => ['nullable', 'array'],
            'login_permissions.*' => [Rule::in(array_keys(User::MODULES))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Please enter the staff member\'s name.',
            'designation_id.required' => 'Please select a designation.',
            'designation_id.integer'  => 'Please select a valid designation.',
            'designation_id.exists'   => 'Please select a Staff designation from the list.',

            'department_id.exists'   => 'The selected department is not valid.',
            'class_id.exists'        => 'The selected class is not valid.',
            'photo.required'         => 'Please upload a photo.',
            'photo.image'            => 'The file must be an image.',
            'photo.mimes'            => 'Photo must be a JPG, PNG or WEBP file.',
            'photo.max'              => 'Photo must not be larger than 10MB.',
            'login_email.email'      => 'Please enter a valid email address.',
            'login_email.unique'     => 'This email is already used by another account.',
            'login_password.min'     => 'Password must be at least 8 characters.',
            'login_email.required_if'  => 'Please enter an email address to enable login for this staff member.',
            'login_password.required'  => 'Please set a password to enable login for this staff member.',

        ];
    }
}

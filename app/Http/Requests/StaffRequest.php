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

        return [
            'name'             => ['required', 'string', 'max:255'],
            'designation'      => ['required', 'string', 'max:255'],
            'department_id'    => ['required', 'exists:departments,id'],
            'class_id'         => ['nullable', 'exists:classes,id'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'show_on_home'     => ['nullable', 'boolean'],

            // Required only when creating (POST); optional when updating
            // (PUT via method spoofing) since an existing photo may be kept.
            'photo' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image', 'mimes:jpg,jpeg,png,webp', 'max:10240',
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
                        ->when($currentStaffId, fn ($q) => $q->where('id', '!=', $currentStaffId))
                        ->exists();

                    if ($alreadyHasHead) {
                        $fail('This department already has a Head of Staff. Remove that designation from the existing head of staff first, then assign it here.');
                    }
                },
            ],

            // Login Access — only matters while "has_login" is turned on.
            'has_login' => ['nullable', 'boolean'],

            'login_email' => [
                'nullable', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($currentUserId),
                function ($attribute, $value, $fail) {
                    if ($this->boolean('has_login') && ! $value) {
                        $fail('Please enter an email address to enable login for this staff member.');
                    }
                },
            ],

            'login_password' => [
                'nullable', 'string', 'min:8',
                function ($attribute, $value, $fail) use ($currentUserId) {
                    // A password is required only the first time login is
                    // switched on (no user account exists yet). Once an
                    // account exists, leaving it blank just keeps the
                    // current password.
                    if ($this->boolean('has_login') && ! $currentUserId && ! $value) {
                        $fail('Please set a password to enable login for this staff member.');
                    }
                },
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
            'designation.required'   => 'Please enter a designation.',
            'department_id.required' => 'Please select a department.',
            'department_id.exists'   => 'The selected department is not valid.',
            'class_id.exists'        => 'The selected class is not valid.',
            'photo.required'         => 'Please upload a photo.',
            'photo.image'            => 'The file must be an image.',
            'photo.mimes'            => 'Photo must be a JPG, PNG or WEBP file.',
            'photo.max'              => 'Photo must not be larger than 10MB.',
            'login_email.email'      => 'Please enter a valid email address.',
            'login_email.unique'     => 'This email is already used by another account.',
            'login_password.min'     => 'Password must be at least 8 characters.',
        ];
    }
}

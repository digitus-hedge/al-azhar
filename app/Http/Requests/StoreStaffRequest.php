<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'designation'      => ['required', 'string', 'max:255'],
            'department'       => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'photo'            => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'is_head_of_staff' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Please enter the staff member\'s name.',
            'designation.required' => 'Please enter a designation.',
            'department.required'  => 'Please enter a department.',
            'photo.required'       => 'Please upload a photo.',
            'photo.image'          => 'The file must be an image.',
            'photo.mimes'          => 'Photo must be a JPG, PNG or WEBP file.',
            'photo.max'            => 'Photo must not be larger than 10MB.',
        ];
    }
}

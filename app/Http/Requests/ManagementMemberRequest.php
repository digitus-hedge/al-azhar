<?php

namespace App\Http\Requests;

use App\Models\ManagementMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Used for both creating and updating a management profile.
 * Form fields: name, designation_id (dropdown), photo (optional), bio (optional).
 */
class ManagementMemberRequest extends FormRequest
{
    public const BIO_MAX = 1000; // characters (plain text)

    public function authorize(): bool
    {
          return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
            'bio'  => $this->filled('bio') ? trim((string) $this->input('bio')) : null,
        ]);
    }

    public function rules(): array
    {
        // On edit: keep the current designation valid even if it was deleted later
        $current = collect($this->route()?->parameters() ?? [])
            ->first(fn ($p) => $p instanceof ManagementMember)?->designation_id;

        return [
            'name'           => ['required', 'string', 'min:2', 'max:150'],
                       'designation_id' => [
                'required',
                'integer',
                Rule::exists('management_designations', 'id')->where(function ($q) use ($current) {
                    $q->where(function ($w) use ($current) {
                        $w->where(function ($x) {
                            $x->whereNull('deleted_at')->where('type', 'management'); // ← only Management
                        });
                        if ($current) {
                            $w->orWhere('id', $current);
                        }
                    });
                }),
            ],
            'photo'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo'   => ['nullable', 'boolean'],
            'bio'            => ['nullable', 'string', 'max:' . self::BIO_MAX],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Please enter the name.',
            'name.min'                => 'Name must be at least 2 characters.',
            'designation_id.required' => 'Please select a designation.',
            'designation_id.integer'  => 'Please select a valid designation.',
                      'designation_id.exists' => 'Please select a Management designation from the list.',
            'photo.image'             => 'The photo must be an image.',
            'photo.mimes'             => 'The photo must be a JPG, PNG or WEBP file.',
            'photo.max'               => 'The photo must not be larger than 2MB.',
            'bio.max'                 => 'The bio must not be more than ' . self::BIO_MAX . ' characters.',
        ];
    }
}

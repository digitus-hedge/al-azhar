<?php

namespace App\Http\Requests;

use App\Models\ManagementMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Used for both creating and updating a management profile.
 * Form fields: name, designation_id (dropdown), photo, bio.
 */
class ManagementMemberRequest extends FormRequest
{
    public const BIO_MIN = 20;   // characters
    public const BIO_MAX = 1000; // characters (plain text)

    public function authorize(): bool
    {
        return true;
    }

    /**
     * The profile being edited, or null when creating.
     */
    protected function member(): ?ManagementMember
    {
        return collect($this->route()?->parameters() ?? [])
            ->first(fn($p) => $p instanceof ManagementMember);
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
        $member  = $this->member();
        $current = $member?->designation_id; // keep current designation valid even if deleted later

        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],

            'designation_id' => [
                'required',
                'integer',
                Rule::exists('management_designations', 'id')->where(function ($q) use ($current) {
                    $q->where(function ($w) use ($current) {
                        $w->where(function ($x) {
                            $x->whereNull('deleted_at')->where('type', 'management'); // only Management
                        });
                        if ($current) {
                            $w->orWhere('id', $current);
                        }
                    });
                }),
            ],

            // Required on create; on edit only if there's no photo yet or it's being removed
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'dimensions:min_width=300,min_height=400',
            ],
            'remove_photo' => ['nullable', 'boolean'],

            'bio' => ['required', 'string', 'min:' . self::BIO_MIN, 'max:' . self::BIO_MAX],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Please enter the name.',
            'name.min'                => 'Name must be at least 2 characters.',
            'designation_id.required' => 'Please select a designation.',
            'designation_id.integer'  => 'Please select a valid designation.',
            'designation_id.exists'   => 'Please select a Management designation from the list.',
            // 'photo.required'          => 'Please upload a profile photo.',
            'photo.image'             => 'The photo must be an image.',
            'photo.mimes'             => 'The photo must be a JPG, PNG or WEBP file.',
            'photo.max'               => 'The photo must not be larger than 2MB.',
            'photo.dimensions'        => 'The photo must be at least 300 × 400 pixels.',
            'bio.required'            => 'Please enter a short bio.',
            'bio.min'                 => 'The bio must be at least ' . self::BIO_MIN . ' characters.',
            'bio.max'                 => 'The bio must not be more than ' . self::BIO_MAX . ' characters.',
        ];
    }
}

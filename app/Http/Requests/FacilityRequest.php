<?php

namespace App\Http\Requests;

use App\Models\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * Single request used for both storing and updating a facility.
 */
class FacilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The facility being edited, or null when creating.
     */
    protected function facility(): ?Facility
    {
        $facility = $this->route('facility');

        if ($facility instanceof Facility) {
            return $facility;
        }

        return $facility ? Facility::find($facility) : null;
    }

    public function rules(): array
    {
        $facility = $this->facility();
        $isUpdate = $facility !== null;

        return [
            'category'          => ['required', Rule::in(array_keys(Facility::CATEGORIES))],
            'title'             => ['required', 'string', 'max:150'],
            'short_description' => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string', 'max:20000'],

            // Cover image: required on create; on update only if there's
            // no existing cover or the user is removing it.
            'image'             => [
                Rule::requiredIf(fn () => ! $isUpdate
                    || empty($facility->image)
                    || $this->boolean('remove_image')),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'remove_image'      => ['nullable', 'boolean'],

            // Gallery: at least one photo on create.
            // On update, the "at least one" check is done in withValidator().
            'gallery'           => $isUpdate
                ? ['nullable', 'array', 'max:20']
                : ['required', 'array', 'min:1', 'max:20'],
            'gallery.*'         => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_gallery'    => ['nullable', 'array'],
            'remove_gallery.*'  => ['string'],

            'icon'              => ['nullable', 'string', 'max:50'],
            'features'          => ['nullable', 'array', 'max:20'],
            'features.*'        => ['nullable', 'string', 'max:100'],

            'capacity'          => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'location'          => ['nullable', 'string', 'max:150'],
            'timings'           => ['nullable', 'string', 'max:100'],
            'contact_person'    => ['nullable', 'string', 'max:100'],
            'contact_phone'     => ['nullable', 'regex:/^[0-9+\-\s]{7,20}$/'],

            'meta_title'        => ['nullable', 'string', 'max:70'],
            'meta_description'  => ['nullable', 'string', 'max:160'],

            'show_on_home'      => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * On update, make sure at least one gallery photo remains
     * after removals and new uploads.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $facility = $this->facility();

            if (! $facility) {
                return; // create is handled by the 'required|min:1' rule
            }

            $existing  = (array) ($facility->gallery ?? []);
            $removed   = (array) $this->input('remove_gallery', []);
            $remaining = count(array_diff($existing, $removed));
            $new       = count((array) $this->file('gallery', []));

            if ($remaining + $new < 1) {
                $validator->errors()->add(
                    'gallery',
                    'Please keep or upload at least one gallery photo.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'category.required'          => 'Please choose a category.',
            'category.in'                => 'Please choose a valid category.',
            'title.required'             => 'Please enter a title.',
            'title.max'                  => 'Title must not be longer than 150 characters.',
            'short_description.required' => 'Please enter a short description.',
            'short_description.max'      => 'Short description must be 255 characters or fewer.',
            'image.required'             => 'Please upload a cover image.',
            'image.image'                => 'Cover must be an image.',
            'image.mimes'                => 'Cover must be a JPG, PNG or WEBP image.',
            'image.max'                  => 'Cover image must not be larger than 5MB.',
            'gallery.required'           => 'Please upload at least one gallery photo.',
            'gallery.min'                => 'Please upload at least one gallery photo.',
            'gallery.max'                => 'You can upload up to 20 photos at a time.',
            'gallery.*.image'            => 'Every gallery file must be an image.',
            'gallery.*.mimes'            => 'Gallery photos must be JPG, PNG or WEBP.',
            'gallery.*.max'              => 'Each gallery photo must not be larger than 5MB.',
            'features.*.max'             => 'Each highlight must be 100 characters or fewer.',
            'capacity.integer'           => 'Capacity must be a number.',
            'contact_phone.regex'        => 'Please enter a valid phone number.',
            'meta_title.max'             => 'Meta title should be 70 characters or fewer.',
            'meta_description.max'       => 'Meta description should be 160 characters or fewer.',
        ];
    }
}
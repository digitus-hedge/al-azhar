<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|min:3|max:80',
            'description' => 'required|string|max:200',

            // Newly uploaded images (0 to 5 files).
            'images'      => 'nullable|array|max:5',
            'images.*'    => 'image|mimes:jpeg,jpg,png,webp|max:10240',

            // Paths of existing images the user chose to keep.
            'keep_images'   => 'nullable|array',
            'keep_images.*' => 'string',

            'meta_title'       => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Please enter a banner title.',
            'title.min'            => 'Title must be at least :min characters.',
            'title.max'            => 'Title cannot exceed :max characters.',

            'description.required' => 'Please enter a banner description.',
            'description.max'      => 'Description cannot exceed :max characters.',

            'meta_title.max'       => 'Meta title cannot exceed :max characters.',
            'meta_description.max' => 'Meta description cannot exceed :max characters.',

            'images.max'      => 'You can upload a maximum of 5 images.',
            'images.*.image'  => 'Each banner image must be a valid image file.',
            'images.*.mimes'  => 'Each banner image must be a JPG, PNG, or WEBP file.',
            'images.*.max'    => 'Each banner image must not exceed 10MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'             => 'banner title',
            'description'       => 'banner description',
            'images'            => 'images',
            'images.*'          => 'image',
            'meta_title'        => 'meta title',
            'meta_description'  => 'meta description',
        ];
    }

    /**
     * Ensures the total image count (existing images kept + newly uploaded)
     * stays within 1 to 5 after this save.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $banner = Banner::first();
            $currentImages = $banner->images ?? [];

            // Only count "keep" paths that actually belong to the current banner.
            $keepCount = collect($this->input('keep_images', []))
                ->filter()
                ->intersect($currentImages)
                ->count();

            $newCount = count($this->file('images', []));

            $total = $keepCount + $newCount;

            if ($total < 1) {
                $validator->errors()->add('images', 'Please upload at least 1 image for the banner.');
            } elseif ($total > 5) {
                $validator->errors()->add('images', 'You can have a maximum of 5 images for the banner.');
            }
        });
    }
}

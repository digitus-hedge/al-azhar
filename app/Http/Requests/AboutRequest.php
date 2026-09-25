<?php

namespace App\Http\Requests;

use App\Models\About;   // ← change if your About model has another name (e.g. AboutSection)
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim((string) $this->input('title')),
        ]);
    }

    /**
     * Single request used for saving the About Section (singleton).
     * Everything is required except the SEO fields (meta_title, meta_description).
     */
    public function rules(): array
    {
        // Image: required only when there is no saved image yet,
        // or when the admin removed the current one without uploading a new one.
        $savedImage  = About::query()->value('image');
        $imageNeeded = ! $savedImage || $this->boolean('remove_image');

        return [
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:5000',  $this->notEmptyHtml()],
            'vision'           => ['required', 'string', 'max:5000',  $this->notEmptyHtml()],
            'mission'          => ['required', 'string', 'max:5000',  $this->notEmptyHtml()],
            'history'          => ['required', 'string', 'max:10000', $this->notEmptyHtml()],
            'values'           => ['required', 'string', 'max:5000',  $this->notEmptyHtml()],

            'image'            => [
                Rule::requiredIf($imageNeeded),
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:5120',
            ],
            'remove_image'     => ['nullable', 'boolean'],

            // SEO — optional
            'meta_title'       => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ];
    }

    /**
     * Rich-text editors (TinyMCE) send "<p>&nbsp;</p>" for an empty box,
     * which passes 'required'. This rule checks there is real text inside.
     */
    private function notEmptyHtml(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) {
            $text = trim(html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $text = trim(str_replace("\u{00A0}", ' ', $text));

            if ($text === '') {
                $fail('Please enter the :attribute.');
            }
        };
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'Please enter the title.',
            'description.required' => 'Please enter the short description.',
            'vision.required'      => 'Please enter the vision.',
            'mission.required'     => 'Please enter the mission.',
            'history.required'     => 'Please enter the history.',
            'values.required'      => 'Please enter the values.',
            'image.required'       => 'Please upload an image.',
            'image.image'          => 'The file must be an image.',
            'image.mimes'          => 'The image must be a JPEG, PNG or WEBP file.',
            'image.max'            => 'The image must not be larger than 5MB.',
            'meta_title.max'       => 'Meta title should be at most 60 characters.',
            'meta_description.max' => 'Meta description should be at most 160 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'description' => 'short description',
        ];
    }
}
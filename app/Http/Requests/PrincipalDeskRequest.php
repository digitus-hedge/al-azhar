<?php

namespace App\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrincipalDeskRequest extends FormRequest
{
    /** Change the excerpt word limit here only. The form reads it from this constant. */
    public const EXCERPT_MAX_WORDS = 600;

    public function authorize(): bool
    {
        return true;
    }

    /** Trim text inputs so "   " counts as empty. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'heading' => trim((string) $this->input('heading')),
            'name'    => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
        ]);
    }

    public function rules(): array
    {
        // Photo is required when there is no saved photo yet (Add),
        // or when the saved one is removed without choosing a new one (Edit).
        $current     = collect($this->route()?->parameters() ?? [])->first(fn ($p) => $p instanceof Model);
        $hasSaved    = (bool) $current?->photo;
        $photoNeeded = ! $hasSaved || $this->boolean('remove_photo');

        return [
            'heading'        => ['required', 'string', 'max:255'],
            'name'           => ['required', 'string', 'max:255'],
            'photo'          => [Rule::requiredIf($photoNeeded), 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_photo'   => ['nullable', 'boolean'],
            'avatar_initial' => ['nullable', 'string', 'max:2'],

            // Excerpt is HTML from TinyMCE, so count WORDS of the visible text, not characters.
            'excerpt' => [
                'required',
                'string',
                'max:65000', // storage safety for a TEXT column (tags included)
                function (string $attribute, mixed $value, \Closure $fail) {
                    $words = self::countWords($value);
                    $max   = self::EXCERPT_MAX_WORDS;

                    if ($words === 0) {
                        $fail('Please enter the short excerpt.');
                    } elseif ($words > $max) {
                        $fail("The short excerpt must not be more than {$max} words (you have {$words}).");
                    }
                },
            ],

            'message'    => ['nullable', 'string'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'heading.required'  => 'Please enter the heading.',
            'heading.max'       => 'The heading may not be longer than 255 characters.',
            'name.required'     => "Please enter the principal's name.",
            'name.max'          => "The principal's name may not be longer than 255 characters.",
            'excerpt.required'  => 'Please enter the short excerpt.',
            'excerpt.max'       => 'The short excerpt is too long.',
            'photo.required'    => "Please upload the principal's photo.",
            'photo.image'       => 'The photo must be an image.',
            'photo.mimes'       => 'The photo must be a JPG, PNG or WEBP file.',
            'photo.max'         => 'The photo must not be larger than 2MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'heading' => 'heading',
            'name'    => "principal's name",
            'excerpt' => 'short excerpt',
            'message' => 'full message',
        ];
    }

    /** Words in HTML content: tags removed, &nbsp; and entities decoded. */
    public static function countWords(?string $html): int
    {
        $text = preg_replace('/<[^>]*>/', ' ', (string) $html);          // "<p>a</p><p>b</p>" -> " a  b "
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/[\s\x{00A0}]+/u', ' ', $text));      // collapse spaces and nbsp

        return $text === '' ? 0 : count(preg_split('/\s+/u', $text));
    }
}

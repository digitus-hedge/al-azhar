<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrincipalDeskRequest extends FormRequest
{
    /** Change the excerpt word limit here only. The form reads it from this constant. */
    public const EXCERPT_MAX_WORDS = 300;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'heading'        => ['required', 'string', 'max:255'],
            'name'           => ['required', 'string', 'max:255'],
            'photo'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
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

    public function attributes(): array
    {
        return [
            'heading' => 'heading',
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
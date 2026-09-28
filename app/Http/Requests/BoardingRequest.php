<?php

namespace App\Http\Requests;

use App\Models\Boarding;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BoardingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => 'required|string|max:191',
            'description'     => 'nullable|string|max:5000',

            // Photos: several at once
            'images'          => 'nullable|array|max:20',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120',          // 5 MB each
            'remove_images'   => 'nullable|array',
            'remove_images.*' => 'string',

            // Videos: several files and/or several links
            'video_files'     => 'nullable|array|max:5',
            'video_files.*'   => 'file|mimetypes:video/mp4,video/webm,video/quicktime|max:51200', // 50 MB each
            'video_links'     => 'nullable|array|max:20',
            'video_links.*'   => 'nullable|string|max:500',
            'remove_videos'   => 'nullable|array',
            'remove_videos.*' => 'integer',

            'fees_title'      => 'nullable|string|max:191',
            'qr_caption'      => 'nullable|string|max:191',
            'fees_qr'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',  // 2 MB
            'remove_qr'       => 'nullable|boolean',
        ];
    }

    /** Every filled-in video link must be a YouTube or Vimeo URL we can embed. */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            foreach ((array) $this->input('video_links', []) as $i => $link) {
                $link = trim((string) $link);
                if ($link !== '' && ! Boarding::embedUrl($link)) {
                    $v->errors()->add("video_links.$i", 'Video link #' . ($i + 1) . ' is not a valid YouTube or Vimeo link.');
                }
            }
        });
    }

    /** Filled-in video links as a clean array (empty rows ignored). */
    public function videoLinks(): array
    {
        return collect((array) $this->input('video_links', []))
            ->map(fn ($l) => trim((string) $l))
            ->filter()
            ->values()
            ->all();
    }

    public function messages(): array
    {
        return [
            'title.required'          => 'Please enter a page title.',
            'images.max'              => 'You can upload up to 20 photos at a time.',
            'images.*.image'          => 'Each photo must be an image.',
            'images.*.mimes'          => 'Photos must be JPG, PNG or WebP.',
            'images.*.max'            => 'Each photo must be 5 MB or smaller.',
            'video_files.max'         => 'You can upload up to 5 video files at a time.',
            'video_files.*.mimetypes' => 'Videos must be MP4, WebM or MOV files.',
            'video_files.*.max'       => 'Each video must be 50 MB or smaller.',
            'video_links.max'         => 'You can add up to 20 video links at a time.',
            'fees_qr.image'           => 'The QR code must be an image.',
            'fees_qr.max'             => 'The QR code image must be 2 MB or smaller.',
        ];
    }
}
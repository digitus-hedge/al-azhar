<?php

namespace App\Http\Requests;

use App\Support\VideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'title' => ['required', 'string', 'max:255'],

            // On create: need a file OR a link. On update: both optional (keep existing).
            'media' => [
                $isCreate ? 'required_without:video_url' : 'nullable',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,mp4,mov,webm,avi',
                'max:10240',
            ],

            'video_url' => [
                $isCreate ? 'required_without:media' : 'nullable',
                'nullable',
                'url',
                'max:500',
                function ($attr, $value, $fail) {
                    if ($value && ! VideoUrl::parse($value)) {
                        $fail('Please enter a valid YouTube (incl. Shorts) or Vimeo link.');
                    }
                },
            ],

            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

  public function withValidator($validator): void
{
    $validator->after(function ($v) {
        $bothSent = $this->hasFile('media') && filled($this->input('video_url'));

        // On update the link field is pre-filled, so an upload simply replaces it
        if ($bothSent && $this->isMethod('post')) {
            $v->errors()->add('video_url', 'Upload a file or paste a link, not both.');
        }
    });
}

    public function messages(): array
    {
        return [
            'title.required'              => 'Please enter a title for this gallery item.',
            'media.required_without'      => 'Upload an image/video or paste a YouTube/Vimeo link.',
            'video_url.required_without'  => 'Upload an image/video or paste a YouTube/Vimeo link.',
            'media.file'                  => 'The upload must be a valid file.',
            'media.mimes'                 => 'Only JPG, PNG, WEBP, GIF images or MP4, MOV, WEBM, AVI videos are allowed.',
            'media.max'                   => 'File must not be larger than 10MB.',
            'video_url.url'               => 'Please enter a valid link (including https://).',
        ];
    }
}
<?php

namespace App\Http\Requests;

use App\Models\NewsNotice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsNoticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Used for both creating and updating a notice.
     */
    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string', 'max:2000'],
            'type'              => ['required', Rule::in(array_keys(NewsNotice::TYPES))],
            'priority'          => ['required', Rule::in(array_keys(NewsNotice::PRIORITIES))],

            // Cover image (optional)
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image'      => ['nullable', 'boolean'],

            // PDF or Word document (optional)
            'attachment'        => [
                'nullable',
                'file',
                'extensions:pdf,doc,docx',
                'mimetypes:application/pdf,application/msword,'
                    . 'application/vnd.openxmlformats-officedocument.wordprocessingml.document,'
                    . 'application/x-ole-storage,application/CDFV2,application/zip',
                'max:10240',
            ],
            'remove_attachment' => ['nullable', 'boolean'],
            'link'              => ['nullable', 'url', 'max:2048'],
            'published_at'      => ['required', 'date'],
            'is_pinned'         => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],

            'meta_title'        => ['nullable', 'string', 'max:70'],
            'meta_description'  => ['nullable', 'string', 'max:160'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'Please enter a title.',
            'type.required'         => 'Please choose a type.',
            'type.in'               => 'Please choose a valid type.',
            'priority.required'     => 'Please choose a priority.',
            'priority.in'           => 'Please choose a valid priority.',
            'image.image'           => 'The image must be a picture file.',
            'image.mimes'           => 'The image must be a JPG, PNG or WEBP file.',
            'image.max'             => 'The image must not be larger than 5MB.',
            'attachment.extensions' => 'The attachment must be a PDF, DOC or DOCX file.',
            'attachment.mimetypes'  => 'The attachment does not look like a valid PDF or Word document.',
            'attachment.max'        => 'The attachment must not be larger than 10MB.',
            'link.url'              => 'Please enter a valid URL (including https://).',
            'published_at.required' => 'Published date is required.',
            'published_at.date'     => 'Please enter a valid date.',
            'meta_title.max'        => 'Meta title should be 70 characters or fewer.',
            'meta_description.max'  => 'Meta description should be 160 characters or fewer.',
        ];
    }
}

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
            'description'       => ['nullable', 'string', 'max:2000'],
            'type'              => ['required', Rule::in(array_keys(NewsNotice::TYPES))],
            'attachment'        => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'remove_attachment' => ['nullable', 'boolean'],
            'link'              => ['nullable', 'url', 'max:2048'],
            'published_at'      => ['required', 'date'],
            'is_pinned'         => ['nullable', 'boolean'],
            'is_active'         => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Please enter a title.',
            'type.in'            => 'Please choose a valid type.',
            'attachment.mimes'  => 'The attachment must be a PDF file.',
            'attachment.max'    => 'The attachment must not be larger than 10MB.',
            'link.url'          => 'Please enter a valid URL (including https://).',
            'published_at.date' => 'Please enter a valid date.',
               'published_at.required' => 'Published Date is Required.',
        ];
    }
}

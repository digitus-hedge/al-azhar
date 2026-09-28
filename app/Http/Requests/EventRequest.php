<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Used for both creating and updating an event.
     */
    public function rules(): array
    {
        // true when editing an existing event (route: events/{event})
        $isUpdate = $this->route('event') !== null;

        return [
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:2000'],
            'event_date'   => ['required', 'date'],
            'event_time'   => ['required', 'date_format:H:i'],
            'venue'        => ['required', 'string', 'max:255'],
               'image' => [
       $isUpdate ? 'required_if:remove_image,1' : 'required',
       'nullable',
       'image',
       'mimes:jpeg,jpg,png,webp',
       'max:5120',
   ],
            'remove_image' => ['nullable', 'boolean'],
            'link'         => ['nullable', 'url', 'max:2048'],
            'is_active'    => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'         => 'Please enter an event title.',
            'description.required'   => 'Please enter an event description.',
            'event_date.required'    => 'Please choose the event date.',
            'event_date.date'        => 'Please enter a valid date.',
            'event_time.required'    => 'Please choose the event time.',
            'event_time.date_format' => 'Please enter a valid time.',
            'venue.required'         => 'Please enter the venue.',
            'image.required'         => 'Please upload an event image.',
            'image.required_if'      => 'Please upload a new image to replace the removed one.',
            'image.image'            => 'The file must be an image.',
            'image.mimes'            => 'The image must be a JPEG, PNG or WEBP file.',
            'image.max'              => 'The image must not be larger than 5MB.',
            'link.url'               => 'Please enter a valid URL (including https://).',
        ];
    }
}
<?php

namespace App\Mail;

use App\Models\AdmissionEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the school office when someone submits the Admission enquiry form.
 *
 * The "From" is the parent's name and email from the form. If the parent left
 * the email empty (it is optional), or $parentAsSender is false, the site's
 * MAIL_FROM_ADDRESS is used with the parent's name. "Reply" goes to the parent
 * whenever an email was given.
 */
class AdmissionEnquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public AdmissionEnquiry $enquiry,
        public bool $parentAsSender = true,
    ) {
    }

    public function envelope(): Envelope
    {
        $e        = $this->enquiry;
        $hasEmail = filled($e->parent_email);
        $parent   = $hasEmail ? new Address($e->parent_email, $e->parent_name) : null;

        return new Envelope(
            from: ($parent && $this->parentAsSender)
                ? $parent
                : new Address(config('mail.from.address'), $e->parent_name . ' (via website)'),
            replyTo: $parent ? [$parent] : [],
            subject: 'New admission enquiry: ' . $e->student_name . ' – ' . $e->grade,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admission-enquiry',
            with: ['a' => $this->enquiry],
        );
    }
}
<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the school office when someone submits the Contact Us form.
 *
 * The "From" is the visitor's own name and email, taken from the saved
 * contact record. "Reply" in the mail client goes straight to the visitor.
 * If $visitorAsSender is false, the site's MAIL_FROM_ADDRESS is used as the
 * sender instead (fallback when the mail server refuses a foreign From).
 */
class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Contact $contact,
        public bool $visitorAsSender = true,
    ) {
    }

    public function envelope(): Envelope
    {
        $visitor = new Address($this->contact->email, $this->contact->name);

        return new Envelope(
            // Visitor as sender, or the site's default sender with the visitor's name
            from: $this->visitorAsSender
                ? $visitor
                : new Address(config('mail.from.address'), $this->contact->name . ' (via website)'),
            replyTo: [$visitor],
            subject: 'New website enquiry: ' . $this->contact->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
            with: ['c' => $this->contact],
        );
    }
}
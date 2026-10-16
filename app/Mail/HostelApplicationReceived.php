<?php

namespace App\Mail;

use App\Models\HostelApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HostelApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public HostelApplication $application
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Hostel Application - Al Azhar Central School'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hostel-application',
            with: ['application' => $this->application],
        );
    }
}
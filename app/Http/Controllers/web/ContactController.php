<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReceived;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    /**
     * /contact-us — show the contact page.
     */
    public function index(): View
    {
        return view('web.contact_us');
    }

    /**
     * POST /contact-us — validate, save the message and email the school.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Honeypot: real visitors never see or fill the "website" field; bots usually do.
        if ($request->filled('website')) {
            return $this->success($request);
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['required', 'email', 'max:191'],
            'phone'   => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{6,20}$/'],
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
            'message.min' => 'Your message should be at least 10 characters.',
        ]);

        $contact = Contact::create($data + [
            'ip_address' => $request->ip(),
        ]);

        $this->notifySchool($contact);

        return $this->success($request);
    }

    /**
     * Email the school office, sent "from" the visitor (email taken from the
     * contact form / saved record). If the mail server refuses to send with the
     * visitor's address as sender, it retries once with the site's own sender,
     * keeping the visitor as Reply-To. The message is already saved, so a mail
     * problem is only logged — the visitor still sees "message sent".
     */
    protected function notifySchool(Contact $contact): void
    {
        $to = config('services.school.email');

        if (blank($to)) {
            Log::warning('Contact form: SCHOOL_MAIL_TO is not set, no email sent.', ['contact_id' => $contact->id]);
            return;
        }

        try {
            Mail::to($to)->send(new ContactMessageReceived($contact));
        } catch (Throwable $e) {
            Log::warning('Contact form: sending as visitor failed, retrying with site sender. ' . $e->getMessage(), ['contact_id' => $contact->id]);

            try {
                Mail::to($to)->send(new ContactMessageReceived($contact, visitorAsSender: false));
            } catch (Throwable $e) {
                Log::error('Contact form email failed: ' . $e->getMessage(), ['contact_id' => $contact->id]);
            }
        }
    }

    protected function success(Request $request): JsonResponse|RedirectResponse
    {
        $message = 'Thank you! Your message has been sent. We will get back to you soon.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('contact.index')->with('success', $message);
    }
}
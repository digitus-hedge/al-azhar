<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * POST /contact-us — validate and save the message.
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

        Contact::create($data + [
            'ip_address' => $request->ip(),
        ]);

        return $this->success($request);
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
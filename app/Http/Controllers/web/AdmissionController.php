<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmissionEnquiryRequest;
use App\Mail\AdmissionEnquiryReceived;
use App\Models\AdmissionEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class AdmissionController extends Controller
{
    public function create(): View
    {
        return view('web.admission', [
            'grades'  => AdmissionEnquiry::GRADES,
            'session' => AdmissionEnquiry::currentSession(),
        ]);
    }

    public function store(StoreAdmissionEnquiryRequest $request): RedirectResponse
    {
        $successMessage = 'Thank you! Our admission team will contact you shortly on your mobile / WhatsApp number.';

        // Honeypot filled => bot. Pretend success, save nothing.
        if ($request->filled('website')) {
            return redirect()->route('admission')->with('success', $successMessage);
        }

        $enquiry = AdmissionEnquiry::create($request->validated() + [
            'status'     => 'new',
            'ip_address' => $request->ip(),
        ]);

        $this->notifySchool($enquiry);

        return redirect()->route('admission')->with('success', $successMessage);
    }

    /**
     * Email the school office, sent "from" the parent (email from the form).
     * If the mail server refuses the parent's address as sender, retry once
     * with the site's own sender (parent stays as Reply-To). The enquiry is
     * already saved, so a mail problem is only logged.
     */
    protected function notifySchool(AdmissionEnquiry $enquiry): void
    {
        $to = config('services.school.email');

        if (blank($to)) {
            Log::warning('Admission form: SCHOOL_MAIL_TO is not set, no email sent.', ['enquiry_id' => $enquiry->id]);
            return;
        }

        try {
            Mail::to($to)->send(new AdmissionEnquiryReceived($enquiry));
        } catch (Throwable $e) {
            Log::warning('Admission form: sending as parent failed, retrying with site sender. ' . $e->getMessage(), ['enquiry_id' => $enquiry->id]);

            try {
                Mail::to($to)->send(new AdmissionEnquiryReceived($enquiry, parentAsSender: false));
            } catch (Throwable $e) {
                Log::error('Admission form email failed: ' . $e->getMessage(), ['enquiry_id' => $enquiry->id]);
            }
        }
    }
}
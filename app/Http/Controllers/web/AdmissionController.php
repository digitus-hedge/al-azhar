<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmissionEnquiryRequest;
use App\Models\AdmissionEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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

        AdmissionEnquiry::create($request->validated() + [
            'status'     => 'new',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admission')->with('success', $successMessage);
    }
}
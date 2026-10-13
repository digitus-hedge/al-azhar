<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WebCareerController extends Controller
{
    /**
     * /careers — list of active career openings.
     */
    public function index(): View
    {
        $careers = Career::active()->ordered()->get();

        return view('web.careers', compact('careers'));
    }

    /**
     * POST /careers/apply — store a career application in the DB.
     */
    public function apply(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'email'       => ['required', 'email', 'max:150'],
            'phone'       => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'career_id'   => ['nullable', 'integer', 'exists:careers,id'],
            'apply_for'   => ['required', 'string', 'max:150'],
            'cv'          => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5 MB
            'message'     => ['nullable', 'string', 'max:2000'],
        ], [
            'phone.regex'     => 'Please enter a valid phone number.',
            'cv.mimes'        => 'Please upload a PDF or Word document only.',
            'cv.max'          => 'CV file must be smaller than 5 MB.',
            'apply_for.required' => 'Please specify the position you are applying for.',
        ]);

        // Handle CV upload
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $data['cv'] = $file->storeAs('career-cvs', $filename, 'public');
        }

        CareerEnquiry::create($data);

        return redirect()
            ->route('careers')
            ->with('success', 'Thank you! Your application has been submitted. Our HR team will contact you shortly.')
            ->withFragment('career-' . ($data['career_id'] ?? ''));
    }
}
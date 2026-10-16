<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostelApplicationRequest;
use App\Models\Boarding;
use App\Models\HostelApplication;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;

use App\Mail\HostelApplicationReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class WebBoardingController extends Controller
{
    /** Public Boarding & Fees page. */
    public function index()
    {
        $boarding = Boarding::first();

        // Classes for the hostel application form dropdown
        $classes = SchoolClass::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('web.boarding', [
            'boarding' => $boarding,
            'images'   => $boarding?->image_urls ?? [],
            'videos'   => $boarding?->video_items ?? [],
            'classes'  => $classes,
        ]);
    }

    /**
     * Keeps backward compatibility if the previous route used __invoke.
     */
    public function __invoke()
    {
        return $this->index();
    }

    /**
     * Store a new hostel application submission.
     */
    public function storeApplication(
    HostelApplicationRequest $request
): RedirectResponse {
    $data = $request->validated();

    // Save the selected class name with the application.
    $class = SchoolClass::find($data['class_id']);
    $data['class_name_snapshot'] = $class?->name;

    // Save the hostel application first.
    $application = HostelApplication::create($data);

    // Get the school's notification email.
    $to = config('services.school.email');

    if (blank($to)) {
        Log::warning(
            'Hostel application: SCHOOL_MAIL_TO is not configured.',
            ['application_id' => $application->id]
        );
    } else {
        try {
            Mail::to($to)->send(
                new HostelApplicationReceived($application)
            );
        } catch (Throwable $e) {
            // Keep the saved application even if email delivery fails.
            Log::error('Hostel application email failed.', [
                'application_id' => $application->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    return redirect()
        ->route('boarding')
        ->with(
            'success',
            'Thank you! Your hostel application has been submitted. Our team will contact you shortly.'
        )
        ->withFragment('hostel-application-form');
}
}
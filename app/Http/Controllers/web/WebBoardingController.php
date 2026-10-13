<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostelApplicationRequest;
use App\Models\Boarding;
use App\Models\HostelApplication;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;

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
    public function storeApplication(HostelApplicationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Snapshot the class name so even if the class row changes later,
        // the admin still sees what was selected at submission time.
        $class = SchoolClass::find($data['class_id']);
        $data['class_name_snapshot'] = $class?->name;

        HostelApplication::create($data);

        return redirect()
            ->route('boarding')
            ->with('success', 'Thank you! Your hostel application has been submitted. Our team will contact you shortly.')
            ->withFragment('hostel-application-form');
    }
}
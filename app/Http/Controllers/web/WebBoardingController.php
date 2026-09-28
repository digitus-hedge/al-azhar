<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Boarding;

class WebBoardingController extends Controller
{
    /** Public Boarding & Fees page. */
    public function __invoke()
    {
        $boarding = Boarding::first();

        return view('web.boarding', [
            'boarding' => $boarding,
            'images'   => $boarding?->image_urls ?? [],
            'videos'   => $boarding?->video_items ?? [],
        ]);
    }
}
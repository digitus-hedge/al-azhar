<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionEnquiry;
use App\Models\Event;
use App\Models\NewsNotice;
use App\Models\Gallery;


class DashboardController extends Controller
{
    public function index()
    {
       
    $newEnquiries = AdmissionEnquiry::where('status', 'new')->count();
    $activeNotices = NewsNotice::count();
    $activeGallery = Gallery::count();
    $upcomingEvents = Event::whereDate('event_date', '>=', today())->count();

    return view('admin.dashboard', compact('newEnquiries','activeNotices','activeGallery','upcomingEvents'));
    }

    public function home()
    {
        return view('admin.home');
    }

    public function homeBanner()
{
    return view('admin.home-banner');
}

public function homeAbout()
{
    return view('admin.home-about');
}

    public function about()
    {
        return view('admin.about');
    }

    public function services()
    {
        return view('admin.services');
    }

    public function contacts()
    {
        return view('admin.contacts');
    }
}

<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class HomeController extends Controller
{
    /**
     * Show the public homepage, including the hero/banner section.
     */
    public function index()
    {
        $banner = Banner::first();

        return view('web.home', compact('banner'));
    }
}
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\View\View;

class WebCurriculumController extends Controller
{
    /**
     * GET /curriculum — list all active curriculums.
     */
    public function index(): View
    {
        $curriculums = Curriculum::active()
            ->orderByDesc('id')
            ->get();

        return view('web.curriculum', compact('curriculums'));
    }
}
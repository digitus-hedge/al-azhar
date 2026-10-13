<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\Fee;

class AcademicController extends Controller
{
    /**
     * Academics page with the class-wise fee structure and academic level details.
     */
    public function index()
    {
        // Position of each class in Fee::CLASSES (Pre.KG = 0 ... XII Commerce = 16)
        $classOrder = array_flip(Fee::CLASSES);

        $fees = Fee::query()
            ->get()
            // Natural class order first, then the admin's sort_order within it
            ->sortBy(fn (Fee $fee) => sprintf(
                '%03d-%05d-%05d',
                $classOrder[$fee->class_name] ?? 999,
                $fee->sort_order,
                $fee->id
            ))
            ->values();

        // Academic details keyed by lowercase name — fetches ALL records
        // (no is_active filter) so modals show whenever admin adds content.
        $academicDetails = Academic::query()
            ->get()
            ->keyBy(fn ($a) => \Illuminate\Support\Str::lower(trim($a->name)));

        return view('web.academics', compact('fees', 'academicDetails'));
    }
}
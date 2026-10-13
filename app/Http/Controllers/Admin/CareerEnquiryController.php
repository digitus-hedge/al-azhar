<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerEnquiry;
use Illuminate\Http\Request;

/**
 * File: app/Http/Controllers/Admin/CareerEnquiryController.php
 *
 * LISTING ONLY (plus a read-only "show" view). No edit, no delete.
 */
class CareerEnquiryController extends Controller
{
    /**
     * List career enquiries with search, filter, sort, pagination.
     * Route: GET /admin/career-enquiries   name: admin.career-enquiries
     */
    public function index(Request $request)
    {
        $search   = trim((string) $request->get('q', ''));
        $careerId = $request->get('career_id', '');
        $sortBy   = $request->get('sort', 'created_at');
        $sortDir  = $request->get('dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $perPage  = (int) $request->get('per_page', 10);

        $perPageOptions = [10, 25, 50, 100];
        if (!in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $allowedSorts = ['name', 'email', 'apply_for', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        $items = CareerEnquiry::query()
            ->with('career:id,title')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%")
                       ->orWhere('apply_for', 'like', "%{$search}%")
                       ->orWhere('nationality', 'like', "%{$search}%");
                });
            })
            ->when(filled($careerId), fn ($q) => $q->where('career_id', $careerId))
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        $careers = Career::orderBy('title')->get(['id', 'title']);

        return view('admin.career-enquiries.index', compact(
            'items', 'search', 'careerId',
            'sortBy', 'sortDir', 'perPage', 'perPageOptions', 'careers'
        ));
    }

    /**
     * Show one enquiry (read-only).
     * Route: GET /admin/career-enquiries/{careerEnquiry}  name: admin.career-enquiries.show
     */
    public function show(CareerEnquiry $careerEnquiry)
    {
        $careerEnquiry->load('career:id,title');

        return view('admin.career-enquiries.show', [
            'item' => $careerEnquiry,
        ]);
    }
}

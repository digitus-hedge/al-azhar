<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeRequest;
use App\Models\Fee;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search  = $request->input('search');

        $fees = Fee::query()
            ->when($search, function ($query, $search) {
                $query->where('class_name', 'like', "%{$search}%");
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.fees.list', compact('fees', 'search', 'perPage'));
    }

    public function create()
    {
        $fee = new Fee(['installments' => 4, 'is_active' => true]);
        return view('admin.fees.form', compact('fee'));
    }

    public function store(FeeRequest $request)
    {
        $data = $this->prepareData($request);

        Fee::create($data);

        return $this->successResponse($request, 'Fee created successfully.');
    }

    public function edit(Fee $fee)
    {
        return view('admin.fees.form', compact('fee'));
    }

    public function update(FeeRequest $request, Fee $fee)
    {
        $data = $this->prepareData($request);

        $fee->update($data);

        return $this->successResponse($request, 'Fee updated successfully.');
    }

    public function destroy(Request $request, Fee $fee)
    {
        $fee->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Fee deleted successfully.']);
        }

        return redirect()
            ->route('admin.fees')
            ->with('success', 'Fee deleted successfully.');
    }

    /**
     * Clean the input and calculate the yearly total.
     */
    private function prepareData(FeeRequest $request): array
    {
        $data = $request->validated();

        $data['installments'] = (int) ($data['installments'] ?? 4);
        $data['total_amount'] = round($data['fee_amount'] * $data['installments'], 2);
        $data['sort_order']   = $data['sort_order'] ?? 0;
        $data['is_active']    = $request->boolean('is_active');

        return $data;
    }

    /**
     * JSON for AJAX forms, redirect for normal submits.
     */
    private function successResponse(Request $request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message'  => $message,
                'redirect' => route('admin.fees'),
            ]);
        }

        return redirect()
            ->route('admin.fees')
            ->with('success', $message);
    }
}
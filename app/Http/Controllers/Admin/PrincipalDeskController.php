<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrincipalDeskRequest;
use App\Models\PrincipalDesk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PrincipalDeskController extends Controller
{
    /**
     * Show the create form.
     * There is only ever one Principal's Desk entry, so this redirects
     * to edit if one already exists.
     */
    public function create(): View|RedirectResponse
    {
        $existing = PrincipalDesk::first();

        if ($existing) {
            return redirect()->route('admin.principal-desk.edit', $existing);
        }

        $item = new PrincipalDesk();

        return view('admin.principal-desk.form', compact('item'));
    }

    /**
     * Store a newly created entry.
     * Responds with JSON when called via the form's AJAX submit.
     */
    public function store(PrincipalDeskRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('principal-desk', 'public');
        }

        $item = PrincipalDesk::create($data);

        $message = "Principal's Desk entry saved successfully.";

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('admin.principal-desk.edit', $item)
            ->with('success', $message);
    }

    /**
     * Show the edit form.
     */
    public function edit(PrincipalDesk $principalDesk): View
    {
        return view('admin.principal-desk.form', ['item' => $principalDesk]);
    }

    /**
     * Update the specified entry.
     * Responds with JSON when called via the form's AJAX submit.
     */
    public function update(PrincipalDeskRequest $request, PrincipalDesk $principalDesk): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($principalDesk->photo) {
                Storage::disk('public')->delete($principalDesk->photo);
            }
            $data['photo'] = $request->file('photo')->store('principal-desk', 'public');
        } elseif ($request->boolean('remove_photo') && $principalDesk->photo) {
            Storage::disk('public')->delete($principalDesk->photo);
            $data['photo'] = null;
        }

        $principalDesk->update($data);

        $message = "Principal's Desk entry updated successfully.";

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('admin.principal-desk.edit', $principalDesk)
            ->with('success', $message);
    }
}

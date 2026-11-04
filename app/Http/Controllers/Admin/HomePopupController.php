<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePopup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomePopupController extends Controller
{
    public function index(): View
    {
        return view('admin.home.popup', ['popup' => HomePopup::settings()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $popup = HomePopup::settings();

        $data = $request->validate([
            'title'        => ['nullable', 'string', 'max:150'],
            'image'        => [$popup->image ? 'nullable' : 'required_if:is_active,1', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'link'         => ['nullable', 'string', 'max:500'],
            'is_active'    => ['nullable', 'boolean'],
            'starts_on'    => ['nullable', 'date'],
            'ends_on'      => ['nullable', 'date', 'after_or_equal:starts_on'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'image.required_if' => 'Upload a popup image before switching the popup on.',
            'image.max'         => 'The image must be 3 MB or smaller.',
        ]);

        // Remove current image
        if ($request->boolean('remove_image') && $popup->image) {
            Storage::disk('public')->delete($popup->image);
            $popup->image = null;
        }

        // Replace image (old file is deleted)
        if ($request->hasFile('image')) {
            if ($popup->image) {
                Storage::disk('public')->delete($popup->image);
            }
            $popup->image = $request->file('image')->store('popups', 'public');
        }

        $popup->fill([
            'title'     => $data['title'] ?? null,
            'link'      => $data['link'] ?? null,
            'is_active' => $request->boolean('is_active') && $popup->image,
            'starts_on' => $data['starts_on'] ?? null,
            'ends_on'   => $data['ends_on'] ?? null,
        ])->save();

        return redirect()->route('admin.home.popup')->with('success', 'Homepage popup saved.');
    }
}

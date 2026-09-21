<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AboutController extends Controller
{
    /**
     * Show the About Section form (singleton — one row).
     */
    public function index()
    {
        $about = About::first() ?? new About();

        return view('admin.about.index', [
            'about' => $about,
        ]);
    }

    /**
     * Create or update the About Section row.
     */
    public function store(AboutRequest $request)
    {
        $about = About::first() ?? new About();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $this->processAndStoreImage($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);

        $about->fill($validated);
        $about->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'About section updated successfully.',
                'about'   => $about,
            ]);
        }

        return redirect()
            ->route('admin.about')
            ->with('success', 'About section updated successfully.');
    }

    /**
     * Resize/convert the uploaded about image and store it on the public disk.
     */
    protected function processAndStoreImage($file): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath())
            ->cover(900, 700)
            ->toWebp(80);

        $filename = 'about/' . uniqid('about_', true) . '.webp';

        Storage::disk('public')->put($filename, (string) $image);

        return $filename;
    }
}

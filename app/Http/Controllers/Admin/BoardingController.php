<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardingRequest;
use App\Models\Boarding;
use Illuminate\Support\Facades\Storage;

class BoardingController extends Controller
{
    /** Show the Boarding / Fees form (single record). */
    public function edit()
    {
        $boarding = Boarding::current();

        return view('admin.boarding.edit', compact('boarding'));
    }

    /** Save the form. */
    public function update(BoardingRequest $request)
    {
        $boarding = Boarding::current();
        $disk     = Storage::disk('public');

        /* ---------- Images ---------- */
        $remove = (array) $request->input('remove_images', []);
        $images = collect($boarding->images ?? [])
            ->reject(function ($path) use ($remove, $disk) {
                if (in_array($path, $remove, true)) {
                    $disk->delete($path);
                    return true;
                }
                return false;
            })
            ->values();

        foreach ($request->file('images', []) as $file) {
            $images->push($file->store('boarding/images', 'public'));
        }

        /* ---------- Videos ---------- */
        $removeVideos = array_map('intval', (array) $request->input('remove_videos', []));
        $videos = collect($boarding->videos ?? [])
            ->values()
            ->reject(function ($video, $index) use ($removeVideos, $disk) {
                if (in_array($index, $removeVideos, true)) {
                    if (($video['type'] ?? '') === 'file') {
                        $disk->delete($video['src']);
                    }
                    return true;
                }
                return false;
            })
            ->values();

        foreach ($request->file('video_files', []) as $file) {
            $videos->push(['type' => 'file', 'src' => $file->store('boarding/videos', 'public')]);
        }

        foreach ($request->videoLinks() as $link) {
            $videos->push(['type' => 'link', 'src' => $link]);
        }

        /* ---------- Fees QR code ---------- */
        $qr = $boarding->fees_qr;

        if ($request->boolean('remove_qr') && $qr) {
            $disk->delete($qr);
            $qr = null;
        }

        if ($request->hasFile('fees_qr')) {
            if ($qr) {
                $disk->delete($qr);
            }
            $qr = $request->file('fees_qr')->store('boarding/qr', 'public');
        }

        /* ---------- Save ---------- */
        $boarding->fill([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'images'      => $images->all(),
            'videos'      => $videos->all(),
            'fees_title'  => $request->input('fees_title'),
            'qr_caption'  => $request->input('qr_caption'),
            'fees_qr'     => $qr,
        ])->save();

        return redirect()->route('admin.boarding')->with('success', 'Boarding page saved.');
    }
}
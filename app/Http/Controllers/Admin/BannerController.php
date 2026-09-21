<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BannerController extends Controller
{
    protected int $imageWidth = 1200;
    protected int $imageHeight = 600;
    protected int $compressQuality = 100;
    protected int $maxImages = 5;

    /**
     * SHOW FORM — always the single banner (or empty model if none exists yet)
     */
    public function index()
    {
        $banner = Banner::first() ?? new Banner();

        return view('admin.banner.form', compact('banner'));
    }

    /**
     * STORE — creates the banner if none exists, otherwise updates the existing one.
     * Images are kept as an ordered array (1 to 5) on the `images` JSON column.
     */
    public function store(BannerRequest $request)
    {
        try {
            $data = $request->validated();

            $banner = Banner::first() ?? new Banner();
            $banner->title             = $data['title'];
            $banner->description       = $data['description'] ?? null;
            $banner->meta_title        = $data['meta_title'] ?? null;
            $banner->meta_description  = $data['meta_description'] ?? null;

            $currentImages = $banner->images ?? [];

            // Existing images the user chose to keep (still present in the form).
            $keepImages = collect($request->input('keep_images', []))
                ->filter()
                ->intersect($currentImages)
                ->values()
                ->all();

            // Delete any current image files that were removed (not kept).
            foreach ($currentImages as $path) {
                if (! in_array($path, $keepImages, true)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // Process and store newly uploaded images.
            $newImages = [];
            foreach ($request->file('images', []) as $file) {
                $newImages[] = $this->processAndStoreImage($file);
                gc_collect_cycles();
            }

            $images = array_values(array_merge($keepImages, $newImages));

            // Safety cap — validation already enforces this, but never trust the client alone.
            $banner->images = array_slice($images, 0, $this->maxImages);

            $banner->save();

            return redirect()
                ->route('admin.home.banner')
                ->with('success', 'Banner saved successfully.');
        } catch (\Throwable $e) {
            \Log::error('Banner store() FAILED', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    private function processAndStoreImage($file): string
    {
        $filename = 'banners/' . Str::random(20) . '.webp';

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname());
        $image->cover($this->imageWidth, $this->imageHeight);
        $encoded = $image->toWebp($this->compressQuality ?? 80);

        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }
}

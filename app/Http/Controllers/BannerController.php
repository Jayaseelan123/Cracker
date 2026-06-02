<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::when($request->search, function ($query) use ($request) {
            $query->where('title', 'LIKE', "%{$request->search}%")
                  ->orWhere('subtitle', 'LIKE', "%{$request->search}%");
        })
        ->latest()
        ->paginate(10);

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        // Get images from public/images
        $imageFiles = File::files(public_path('images'));
        $images = [];
        foreach ($imageFiles as $file) {
            if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $images[] = 'images/' . $file->getFilename();
            }
        }
        
        return view('admin.banners.create', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $request->image,
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        $imageFiles = File::files(public_path('images'));
        $images = [];
        foreach ($imageFiles as $file) {
            if (in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $images[] = 'images/' . $file->getFilename();
            }
        }

        return view('admin.banners.edit', compact('banner', 'images'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $request->image,
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Update the banner status via dropdown (Active / Inactive).
     */
    public function toggleStatus(Request $request, Banner $banner)
    {
        $banner->is_active = $request->input('is_active') ? 1 : 0;
        $banner->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status updated']);
        }

        $label = $banner->is_active ? 'Active' : 'Inactive';
        return redirect()->route('banners.index')->with('success', 'Banner status updated to ' . $label . '.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}

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
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $uploadDir = public_path('images/banners');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $image->move($uploadDir, $filename);
            $imagePath = 'images/banners/' . $filename;
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'is_active' => $request->input('is_active'),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $banner->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $uploadDir = public_path('images/banners');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $image->move($uploadDir, $filename);
            $imagePath = 'images/banners/' . $filename;

            // Delete old image if exists
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
        }

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index()
    {
        $blogs = Blog::latest('updated_at')->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'excerpt'      => 'nullable|string|max:500',
            'category'     => 'required|string|max:100',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Checkbox: not sent when unchecked, so read it explicitly
        $validated['is_published'] = $request->boolean('is_published');

        // Ensure upload directory exists
        $uploadDir = public_path('images/blog');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->move($uploadDir, $filename);
            $validated['image'] = 'images/blog/' . $filename;
        }

        // Auto-generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Auto-set published_at when publishing immediately
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'excerpt'      => 'nullable|string|max:500',
            'category'     => 'required|string|max:100',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Checkbox: not sent when unchecked
        $validated['is_published'] = $request->boolean('is_published');

        // Ensure upload directory exists
        $uploadDir = public_path('images/blog');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            $image    = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->move($uploadDir, $filename);
            $validated['image'] = 'images/blog/' . $filename;
        }

        // Auto-generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Auto-set published_at when publishing
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        // Delete image
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
                        ->with('success', 'Blog post deleted successfully!');
    }
}

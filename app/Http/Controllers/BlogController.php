<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of all published blog posts.
     */
    public function index()
    {
        $blogs = Blog::published()->paginate(10);
        return view('front.blog', compact('blogs'));
    }

    /**
     * Display a single blog post.
     */
    public function show(Blog $blog)
    {
        // Increment view count
        $blog->incrementViews();

        // Get related posts (same category, exclude current)
        $relatedPosts = Blog::published()
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        return view('front.blog-single', compact('blog', 'relatedPosts'));
    }

    /**
     * Filter posts by category
     */
    public function filterByCategory($category)
    {
        $blogs = Blog::published()
            ->where('category', $category)
            ->paginate(10);

        return view('front.blog', compact('blogs', 'category'));
    }
}

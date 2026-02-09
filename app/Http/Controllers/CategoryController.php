<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tamil_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255'
        ]);

        $slugSource = $request->input('slug') ?: $request->input('name');
        $base = Str::slug($slugSource);
        $slug = $base;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        Category::create([
            'name' => $request->name,
            'tamil_name' => $request->tamil_name,
            'slug' => $slug
        ]);

        return redirect()->route('category.index')->with('success', 'Category Added Successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tamil_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255'
        ]);

        $slugSource = $request->input('slug') ?: $request->input('name');
        $base = Str::slug($slugSource);
        $slug = $base;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        $category->update([
            'name' => $request->name,
            'tamil_name' => $request->tamil_name,
            'slug' => $slug
        ]);

        return redirect()->route('category.index')->with('success', 'Category Updated Successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category Deleted!');
    }
}

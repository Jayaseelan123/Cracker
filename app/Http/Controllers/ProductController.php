<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name_en', 'LIKE', "%{$request->search}%")
                    ->orWhere('name_ta', 'LIKE', "%{$request->search}%");
            })
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Build validation rules only for columns that exist in the DB
        $rules = [];
        if (Schema::hasColumn('products', 'sku')) {
            $rules['sku'] = 'required|string|max:255|unique:products,sku';
        }
        if (Schema::hasColumn('products', 'name_en')) {
            $rules['name_en'] = 'required|string|max:255';
        }
        if (Schema::hasColumn('products', 'name_ta')) {
            $rules['name_ta'] = 'nullable|string|max:255';
        }
        if (Schema::hasColumn('products', 'category_id')) {
            $rules['category_id'] = 'required|exists:categories,id';
        }
        if (Schema::hasColumn('products', 'rate')) {
            $rules['rate'] = 'required|numeric';
        }
        // If DB uses `price`/`mrp` instead of `rate`, validate those
        if (Schema::hasColumn('products', 'price')) {
            $rules['price'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'mrp')) {
            $rules['mrp'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'discount_rate')) {
            $rules['discount_rate'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'final_price')) {
            $rules['final_price'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'stock')) {
            $rules['stock'] = 'nullable|integer';
        }
        if (Schema::hasColumn('products', 'image')) {
            $rules['image'] = 'nullable|image|max:5120';
        }

        $validated = $request->validate($rules);

        $data = $request->except('image');
        // Remove any request keys that are not actual product table columns
        $columns = Schema::getColumnListing('products');
        $data = array_intersect_key($data, array_flip($columns));
        // If developer submitted name_en but DB only has 'name', map it so edits persist
        if (!in_array('name_en', $columns) && in_array('name', $columns) && $request->filled('name_en')) {
            $data['name'] = $request->input('name_en');
        }
        // If DB has 'name' but request did not provide it, try to map from name_en
        if (in_array('name', $columns) && empty($data['name'])) {
            if ($request->filled('name_en')) {
                $data['name'] = $request->input('name_en');
            } elseif ($request->filled('name')) {
                $data['name'] = $request->input('name');
            } else {
                return back()->withInput()->withErrors(['name' => 'Product name is required.']);
            }
        }
        // If DB uses name_en column (no 'name') ensure name_en exists
        if (!in_array('name', $columns) && in_array('name_en', $columns) && empty($data['name_en'])) {
            if ($request->filled('name')) {
                $data['name_en'] = $request->input('name');
            } else {
                return back()->withInput()->withErrors(['name_en' => 'Product name (English) is required.']);
            }
        }
        // Map rate -> price and mrp if DB uses price/mrp instead of rate
        if ($request->filled('rate')) {
            if (in_array('price', $columns)) {
                // Use final_price if it's set and greater than 0, otherwise use rate (MRP)
                if ($request->filled('final_price') && $request->input('final_price') > 0) {
                    $data['price'] = $request->input('final_price');
                } else {
                    $data['price'] = $request->input('rate');
                }
            }
            if (in_array('mrp', $columns)) {
                // treat submitted rate as original mrp when mrp field exists
                $data['mrp'] = $request->input('rate');
            }
        }

        // Ensure required price/mrp columns are present (map or error)
        if (in_array('price', $columns) && empty($data['price'])) {
            return back()->withInput()->withErrors(['price' => 'Product price is required.']);
        }
        if (in_array('mrp', $columns) && empty($data['mrp'])) {
            // if mrp is missing but price exists, use price as mrp fallback
            if (!empty($data['price'])) {
                $data['mrp'] = $data['price'];
            } else {
                return back()->withInput()->withErrors(['mrp' => 'Product MRP is required.']);
            }
        }


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product_images'), $filename);
            // map to DB column if different
            if (in_array('image_path', $columns)) {
                $data['image_path'] = $filename;
            } elseif (in_array('image', $columns)) {
                $data['image'] = $filename;
            }
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product Added Successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Build update validation rules based on existing DB columns
        $rules = [];
        if (Schema::hasColumn('products', 'sku')) {
            $rules['sku'] = 'required|string|max:255|unique:products,sku,' . $product->id;
        }
        if (Schema::hasColumn('products', 'name_en')) {
            $rules['name_en'] = 'required|string|max:255';
        }
        if (Schema::hasColumn('products', 'name_ta')) {
            $rules['name_ta'] = 'nullable|string|max:255';
        }
        if (Schema::hasColumn('products', 'category_id')) {
            $rules['category_id'] = 'required|exists:categories,id';
        }
        if (Schema::hasColumn('products', 'rate')) {
            $rules['rate'] = 'required|numeric';
        }
        if (Schema::hasColumn('products', 'discount_rate')) {
            $rules['discount_rate'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'final_price')) {
            $rules['final_price'] = 'nullable|numeric';
        }
        if (Schema::hasColumn('products', 'stock')) {
            $rules['stock'] = 'nullable|integer';
        }
        if (Schema::hasColumn('products', 'image')) {
            $rules['image'] = 'nullable|image|max:5120';
        }

        $validated = $request->validate($rules);

        $data = $request->except('image');
        // Remove any request keys that are not actual product table columns
        $columns = Schema::getColumnListing('products');
        $data = array_intersect_key($data, array_flip($columns));
        // Map name_en into name if necessary
        if (!in_array('name_en', $columns) && in_array('name', $columns) && $request->filled('name_en')) {
            $data['name'] = $request->input('name_en');
        }
        // Map rate into price and mrp for legacy schemas
        if ($request->filled('rate')) {
            if (in_array('price', $columns)) {
                if ($request->filled('final_price') && $request->input('final_price') > 0) {
                    $data['price'] = $request->input('final_price');
                } else {
                    $data['price'] = $request->input('rate');
                }
            }
            if (in_array('mrp', $columns)) {
                $data['mrp'] = $request->input('rate');
            }
        }

        if ($request->hasFile('image')) {
            // delete old image if exists (support either image or image_path)
            if (!empty($product->image_path) && file_exists(public_path('product_images/' . $product->image_path))) {
                @unlink(public_path('product_images/' . $product->image_path));
            } elseif (!empty($product->image) && file_exists(public_path('product_images/' . $product->image))) {
                @unlink(public_path('product_images/' . $product->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product_images'), $filename);
            if (in_array('image_path', $columns)) {
                $data['image_path'] = $filename;
            } elseif (in_array('image', $columns)) {
                $data['image'] = $filename;
            }
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully!');
    }

    /**
     * Resource show route is defined by resource routes. Provide a simple redirect
     * to the edit page to avoid "undefined method show()" errors when a GET
     * request hits /products/{id} and the application expects a show method.
     */
    public function show(Product $product)
    {
        return redirect()->route('products.edit', $product->id);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // delete image file if exists
        if (!empty($product->image) && file_exists(public_path('product_images/' . $product->image))) {
            @unlink(public_path('product_images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully!');
    }
}

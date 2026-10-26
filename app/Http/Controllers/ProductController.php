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
                    ->orWhere('name_ta', 'LIKE', "%{$request->search}%")
                    ->orWhere('product_id', 'LIKE', "%{$request->search}%");
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
        if (Schema::hasColumn('products', 'name_en')) {
            $rules['name_en'] = 'required|string|max:255';
        }
        if (Schema::hasColumn('products', 'name_ta')) {
            $rules['name_ta'] = 'nullable|string|max:255';
        }
        if (Schema::hasColumn('products', 'content')) {
            $rules['content'] = 'nullable|string|max:255';
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
            $rules['final_price'] = 'required|numeric';
        }
        if (Schema::hasColumn('products', 'stock')) {
            $rules['stock'] = 'required|integer|min:1';
        }
        if (Schema::hasColumn('products', 'image')) {
            $rules['image'] = 'nullable|image|max:5120';
        }
        if (Schema::hasColumn('products', 'video')) {
            $rules['video'] = 'nullable|mimetypes:video/mp4,video/webm,video/ogg,video/avi,video/quicktime|max:51200';
        }
        if (Schema::hasColumn('products', 'video_url')) {
            $rules['video_url'] = 'nullable|url|max:255';
        }
        if (Schema::hasColumn('products', 'video_status')) {
            $rules['video_status'] = 'nullable|in:Active,Inactive';
        }

        // Product ID: required and unique across all products
        if (Schema::hasColumn('products', 'product_id')) {
            $rules['product_id'] = 'required|string|max:20|unique:products,product_id';
        }

        $validated = $request->validate($rules);

        // Prevent negative final price
        if ($request->filled('discount_rate') && $request->filled('rate') && $request->discount_rate > $request->rate) {
            return back()->withInput()->withErrors(['discount_rate' => 'Discount cannot be greater than the Rate (MRP).']);
        }

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

        if ($request->hasFile('video') && in_array('video', $columns)) {
            if (!file_exists(public_path('product_videos'))) {
                mkdir(public_path('product_videos'), 0755, true);
            }
            $vfile = $request->file('video');
            $vfilename = time() . '_' . $vfile->getClientOriginalName();
            $vfile->move(public_path('product_videos'), $vfilename);
            $data['video'] = $vfilename;
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
        if (Schema::hasColumn('products', 'name_en')) {
            $rules['name_en'] = 'required|string|max:255';
        }
        if (Schema::hasColumn('products', 'name_ta')) {
            $rules['name_ta'] = 'nullable|string|max:255';
        }
        if (Schema::hasColumn('products', 'content')) {
            $rules['content'] = 'nullable|string|max:255';
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
            $rules['final_price'] = 'required|numeric';
        }
        if (Schema::hasColumn('products', 'stock')) {
            $rules['stock'] = 'required|integer|min:1';
        }
        if (Schema::hasColumn('products', 'image')) {
            $rules['image'] = 'nullable|image|max:5120';
        }
        if (Schema::hasColumn('products', 'video')) {
            $rules['video'] = 'nullable|mimetypes:video/mp4,video/webm,video/ogg,video/avi,video/quicktime|max:51200';
        }
        if (Schema::hasColumn('products', 'video_url')) {
            $rules['video_url'] = 'nullable|url|max:255';
        }
        if (Schema::hasColumn('products', 'video_status')) {
            $rules['video_status'] = 'nullable|in:Active,Inactive';
        }

        // Product ID: required and unique, but allow keeping the same value on update
        if (Schema::hasColumn('products', 'product_id')) {
            $rules['product_id'] = 'required|string|max:20|unique:products,product_id,' . $product->id;
        }

        $validated = $request->validate($rules);

        // Prevent negative final price
        if ($request->filled('discount_rate') && $request->filled('rate') && $request->discount_rate > $request->rate) {
            return back()->withInput()->withErrors(['discount_rate' => 'Discount cannot be greater than the Rate (MRP).']);
        }

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

        if ($request->hasFile('video') && in_array('video', $columns)) {
            // delete old video
            if (!empty($product->video) && file_exists(public_path('product_videos/' . $product->video))) {
                @unlink(public_path('product_videos/' . $product->video));
            }
            if (!file_exists(public_path('product_videos'))) {
                mkdir(public_path('product_videos'), 0755, true);
            }
            $vfile = $request->file('video');
            $vfilename = time() . '_' . $vfile->getClientOriginalName();
            $vfile->move(public_path('product_videos'), $vfilename);
            $data['video'] = $vfilename;
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
     * Update the product status via dropdown (Active / Inactive).
     */
    public function toggleStatus(Request $request, Product $product)
    {
        $status = $request->input('status', 'Active');
        $product->status = in_array($status, ['Active', 'Inactive']) ? $status : 'Active';
        $product->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status updated to ' . $product->status]);
        }

        return redirect()->route('products.index')->with('success', 'Product status updated to ' . $product->status . '.');
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
        // delete video file if exists
        if (!empty($product->video) && file_exists(public_path('product_videos/' . $product->video))) {
            @unlink(public_path('product_videos/' . $product->video));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully!');
    }
    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ]);

        try {
            set_time_limit(300);
            ini_set('memory_limit', '512M');

            $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($request->file('excel_file'));

            // Check headers on the first row
            $firstRow = $collection->first();
            if ($firstRow) {
                $normalizedKeys = [];
                foreach (array_keys($firstRow) as $key) {
                    $normalizedKeys[] = strtolower(trim($key));
                }
                
                $nameAliases = ['name_en', 'name', 'product name', 'name (en)', 'name en'];
                $hasName = array_intersect($nameAliases, $normalizedKeys);
                if (empty($hasName)) {
                    return redirect()->back()->with('error', 'Error: Required column "NAME (EN)" or "Product Name" is missing in the Excel file.');
                }
                
                $rateAliases = ['rate', 'price', 'mrp'];
                $hasRate = array_intersect($rateAliases, $normalizedKeys);
                if (empty($hasRate)) {
                    return redirect()->back()->with('error', 'Error: Required column "RATE" or "Price" is missing in the Excel file.');
                }
            }

            $count = 0;
            $failures = [];
            $rowIndex = 1;

            foreach ($collection as $row) {
                $rowIndex++;

                $normalizedRow = [];
                foreach ($row as $key => $value) {
                    $normalizedRow[strtolower(trim($key))] = is_string($value) ? trim($value) : $value;
                }

                $isEmptyRow = true;
                foreach ($normalizedRow as $val) {
                    if (!empty($val)) {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) {
                    continue; 
                }

                // Read from Excel headers (case-insensitive checks)
                $productId = $normalizedRow['product_id'] ?? $normalizedRow['product id'] ?? null;
                $nameEn = $normalizedRow['name (en)'] ?? $normalizedRow['name en'] ?? $normalizedRow['name_en'] ?? $normalizedRow['name'] ?? $normalizedRow['product name'] ?? null;
                $nameTa = $normalizedRow['name (ta)'] ?? $normalizedRow['name ta'] ?? $normalizedRow['name_ta'] ?? $normalizedRow['tamil name'] ?? null;
                $categoryName = $normalizedRow['category'] ?? $normalizedRow['category name'] ?? null;
                $rate = $normalizedRow['rate'] ?? $normalizedRow['price'] ?? $normalizedRow['mrp'] ?? 0;
                $discountRate = $normalizedRow['discount'] ?? $normalizedRow['discount rate'] ?? $normalizedRow['discount_rate'] ?? 0;
                $finalPrice = $normalizedRow['final price'] ?? $normalizedRow['final_price'] ?? $rate;
                $stock = $normalizedRow['stock'] ?? $normalizedRow['qty'] ?? $normalizedRow['quantity'] ?? 0;
                $status = $normalizedRow['status'] ?? 'Active';

                if (empty($nameEn)) {
                    $failures[] = "Row {$rowIndex}: Missing Product Name.";
                    continue; 
                }

                if (empty($rate) || !is_numeric($rate)) {
                    $failures[] = "Row {$rowIndex}: Missing or invalid Rate/Price for product '{$nameEn}'.";
                    continue;
                }

                if (empty($productId)) {
                    $productId = 'CKR-' . strtoupper(\Illuminate\Support\Str::random(6));
                }

               // Category is compulsory - must already exist in categories table
                if (empty($categoryName)) {
                    $failures[] = "Row {$rowIndex}: Missing Category for product '{$nameEn}'.";
                    continue;
                }
                
                $category = Category::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($categoryName))])->first();
                
                if (!$category) {
                    $failures[] = "Row {$rowIndex}: Category '{$categoryName}' not found. Please add this category first, or check spelling.";
                    continue;
                }
                
                $categoryId = $category->id;

                $data = [
                    'name_en' => $nameEn,
                    'name' => $nameEn,
                    'name_ta' => $nameTa,
                    'category_id' => $categoryId,
                    'rate' => $rate,
                    'price' => $finalPrice,
                    'mrp' => $rate,
                    'discount_rate' => $discountRate,
                    'final_price' => $finalPrice,
                    'stock' => $stock,
                    'status' => in_array(ucfirst($status), ['Active', 'Inactive']) ? ucfirst($status) : 'Active'
                ];

                $columns = \Illuminate\Support\Facades\Schema::getColumnListing('products');
                $data = array_intersect_key($data, array_flip($columns));
                $data['product_id'] = $productId; 

                Product::updateOrCreate(
                    ['product_id' => $productId],
                    $data
                );
                
                $count++;
            }

            $msg = "{$count} Products imported successfully!";
            if (count($failures) > 0) {
                $msg .= "<br><b class='text-danger'>" . count($failures) . " rows failed:</b><ul class='mb-0 mt-2 text-start text-danger' style='font-size:0.85rem;'>";
                foreach (array_slice($failures, 0, 10) as $f) {
                    $msg .= "<li>{$f}</li>";
                }
                if (count($failures) > 10) {
                    $msg .= "<li>...and " . (count($failures) - 10) . " more.</li>";
                }
                $msg .= "</ul>";
            } else {
                $msg .= "<br><b>0 rows failed.</b>";
            }

            return redirect()->route('products.index')->with('success', $msg);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Product Excel Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error importing Excel: ' . $e->getMessage());
        }
    }
    public function exportExcel()
    {
        $products = Product::with('category')->get();
        
        return (new \Rap2hpoutre\FastExcel\FastExcel($products))->download('products.xlsx', function ($product) {
            return [
                'Product ID' => $product->product_id,
                'Name (EN)' => $product->name_en ?? $product->name,
                'Name (TA)' => $product->name_ta,
                'Category' => optional($product->category)->name,
                'Content'        => $product->content ?? null,
                'Rate' => $product->rate ?? $product->price ?? $product->mrp ?? 0,
                'Discount Rate' => $product->discount_rate ?? 0,
                'Final Price' => $product->final_price ?? $product->price ?? 0,
                'Stock' => $product->stock,
                'Status' => $product->status,
            ];
        });
    }
}

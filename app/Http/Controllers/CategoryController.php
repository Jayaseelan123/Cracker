<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($query) use ($request) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                ->orWhere('tamil_name', 'LIKE', "%{$request->search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'tamil_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $slugSource = $request->input('slug') ?: $request->input('name');
        $base = Str::slug($slugSource);
        $slug = $base;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('category_images'), $imageName);
        }

        Category::create([
            'name' => $request->name,
            'tamil_name' => $request->tamil_name,
            'slug' => $slug,
            'image' => $imageName
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
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'tamil_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $slugSource = $request->input('slug') ?: $request->input('name');
        $base = Str::slug($slugSource);
        $slug = $base;
        $counter = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        $imageName = $category->image;
        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
                unlink(public_path('category_images/' . $category->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('category_images'), $imageName);
        }

        $category->update([
            'name' => $request->name,
            'tamil_name' => $request->tamil_name,
            'slug' => $slug,
            'image' => $imageName
        ]);

        return redirect()->route('category.index')->with('success', 'Category Updated Successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
            unlink(public_path('category_images/' . $category->image));
        }
        $category->delete();
        return back()->with('success', 'Category Deleted!');
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

            $count = 0;
            $failures = [];
            $rowIndex = 1; // row 1 is header

            foreach ($collection as $row) {
                $rowIndex++;
                
                // Normalize keys (lowercase, trim spaces)
                $normalizedRow = [];
                foreach ($row as $key => $value) {
                    $normalizedRow[strtolower(trim($key))] = is_string($value) ? trim($value) : $value;
                }

                // 10. Blank rows are skipped safely
                // Check if all values are empty
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

                // Identify columns robustly
                $name = $normalizedRow['name'] ?? $normalizedRow['category name'] ?? $normalizedRow['category'] ?? null;
                $tamilName = $normalizedRow['tamil_name'] ?? $normalizedRow['tamil name'] ?? $normalizedRow['name (ta)'] ?? null;
                $slugSource = $normalizedRow['slug'] ?? $name;

                // Validation
                if (empty($name)) {
                    $failures[] = "Row {$rowIndex}: Missing Category Name.";
                    continue;
                }

                // Duplicate check
                $exists = Category::where('name', $name)->first();
                if ($exists) {
                    $failures[] = "Row {$rowIndex}: Category '{$name}' already exists.";
                    continue;
                }

                $base = \Illuminate\Support\Str::slug($slugSource);
                $slug = $base;
                $counter = 1;
                while (Category::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter;
                    $counter++;
                }

                Category::create([
                    'name' => $name,
                    'tamil_name' => $tamilName,
                    'slug' => $slug,
                    'image' => null
                ]);
                $count++;
            }

            $msg = "{$count} Categories imported successfully!";
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

            return redirect()->route('category.index')->with('success', $msg);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Category Excel Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error importing Excel: ' . $e->getMessage());
        }
    }
    public function exportExcel()
    {
        $categories = Category::all();
        
        return (new \Rap2hpoutre\FastExcel\FastExcel($categories))->download('categories.xlsx', function ($category) {
            return [
                'Name' => $category->name,
                'Tamil Name' => $category->tamil_name,
                'Slug' => $category->slug,
            ];
        });
    }
}

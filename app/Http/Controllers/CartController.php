<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        // Build items array for views that expect detailed product info
        $items = [];
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (!$product)
                continue;
            $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
            $total = $price * $qty;
            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'total' => $total,
            ];
            $subtotal += $total;
        }

        $packing = 0;
        $total = $subtotal + $packing;

        return view('cart.index', compact('cart', 'items', 'subtotal', 'packing', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);
        $currentQty = $cart[$id] ?? 0;
        $newTotalQty = $currentQty + $quantity;

        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
            if ($product->stock < $newTotalQty) {
                return redirect()->back()->with('error', 'Only ' . $product->stock . ' items available in stock.');
            }
        }

        $cart[$id] = $newTotalQty;
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $quantity = max(0, (int) $request->input('quantity', 0));
        $cart = session('cart', []);
        
        if ($quantity > 0 && \Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
            if ($product->stock < $quantity) {
                return redirect()->back()->with('error', 'Only ' . $product->stock . ' items available in stock.');
            }
        }

        if ($quantity <= 0) {
            // remove item when quantity is zero or less
            if (isset($cart[$id])) {
                unset($cart[$id]);
            }
        } else {
            $cart[$id] = $quantity;
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, $id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * AJAX add (increment) - returns JSON
     */
    public function ajaxAdd(Request $request, $id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        $cart = session()->get('cart', []);
        $currentQty = $cart[$id] ?? 0;

        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
            if ($product->stock <= $currentQty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->stock . ' items available in stock'
                ]);
            }
        }

        $cart[$id] = $currentQty + 1;
        session()->put('cart', $cart);

        // return minimal info; front-end will refresh drawer html
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    /**
     * AJAX decrease (decrement) - returns JSON
     */
    public function ajaxDecrease(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
        }
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    /**
     * AJAX update (set quantity) - returns JSON
     */
    public function ajaxUpdate(Request $request, $id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        $qty = max(0, intval($request->input('quantity', 0)));
        
        if ($qty > 0 && \Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
            if ($product->stock < $qty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->stock . ' items available in stock'
                ]);
            }
        }

        $cart = session()->get('cart', []);

        if ($qty <= 0) {
            if (isset($cart[$id]))
                unset($cart[$id]);
        } else {
            $cart[$id] = $qty;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    /**
     * AJAX remove - delete item from cart
     */
    public function ajaxRemove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id]))
            unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }
}

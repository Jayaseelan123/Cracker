<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
            $itemTotal = $price * $qty;
            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'total' => $itemTotal,
            ];
            $subtotal += $itemTotal;
        }

        $packing = 0;
        $total = $subtotal + $packing;

        return view('front.checkout', compact('items', 'subtotal', 'packing', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'phone' => ['required','regex:/^[0-9]{10}$/'],
            'email' => 'nullable|email|max:191',
            'address' => 'required|string',
            'city' => 'required|string|max:120',
            'state' => 'required|string|max:120',
            'pin' => 'nullable|string|max:20',
        ]);

        $cart = session('cart', []);
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
            $subtotal += $price * $qty;
        }

        $packing = 0;
        $total = $subtotal + $packing;

        try {
            $order = DB::transaction(function () use ($data, $cart, $subtotal, $packing, $total) {
                $orderNumber = 'ORD' . time();

                $orderPayload = [];
                if (\Illuminate\Support\Facades\Schema::hasTable('orders')) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'order_number')) {
                        $orderPayload['order_number'] = $orderNumber;
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_name')) {
                        $orderPayload['customer_name'] = $data['name'];
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_phone')) {
                        $orderPayload['customer_phone'] = $data['phone'];
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_address')) {
                        $orderPayload['customer_address'] = $data['address'] . ', ' . $data['city'] . ', ' . $data['state'] . ' - ' . ($data['pin'] ?? '');
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'total_amount')) {
                        $orderPayload['total_amount'] = $total;
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'status')) {
                        $orderPayload['status'] = 'pending';
                    }
                }

                $order = Order::create($orderPayload);

                foreach ($cart as $productId => $qty) {
                    $product = \App\Models\Product::find($productId);
                    if (! $product) continue;
                    $price = $product->price ?? $product->rate ?? $product->mrp ?? 0;
                    $itemTotal = $price * $qty;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'total' => $itemTotal,
                    ]);

                    if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
                        try { $product->decrement('stock', $qty); } catch (\Throwable $e) { }
                    }
                }

                return $order;
            });
        } catch (\Throwable $ex) {
            logger()->error('Order persist failed', ['error' => $ex->getMessage(), 'data' => $data, 'cart' => $cart]);
            return redirect()->route('home')->with('error', 'There was a problem placing your order. Please try again.');
        }

        session(['cart' => []]);

        return redirect()->route('order.success', ['order' => $order->id]);
    }

    public function success(Order $order)
    {
        return view('front.success', compact('order'));
    }
}

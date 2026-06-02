<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DeliveryZone;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price     = $product->price ?? $product->rate ?? $product->mrp ?? 0;
            $itemTotal = $price * $qty;
            $items[]   = ['product' => $product, 'qty' => $qty, 'total' => $itemTotal];
            $subtotal += $itemTotal;
        }

        $packing = 0;
        $total   = $subtotal + $packing;

        // Load active delivery zones for the state dropdown
        $deliveryZones = DeliveryZone::where('is_active', true)->orderBy('sort_order')->get();

        return view('front.checkout', compact('items', 'subtotal', 'packing', 'total', 'deliveryZones'));
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:191',
            'phone'   => ['required', 'regex:/^[0-9]{10}$/'],
            'email'   => 'nullable|email|max:191',
            'address' => 'required|string',
            'city'    => 'required|string|max:120',
            'state'   => 'required|string|max:120',
            'pin'     => 'nullable|string|max:20',
            'place'   => 'nullable|string|max:191',
        ]);

        $cart = session('cart', []);
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price     = $product->price ?? $product->rate ?? $product->mrp ?? 0;
            $subtotal += $price * $qty;
        }

        // Resolve delivery zone for the chosen state
        $zone = DeliveryZone::where('is_active', true)
                    ->whereRaw('LOWER(state_name) = ?', [strtolower(trim($data['state']))])
                    ->first();

        $packing  = $zone ? (float) $zone->packing_charges  : 0;
        $minOrder = $zone ? (float) $zone->min_order_amount  : 0;

        // Enforce minimum order amount
        if ($minOrder > 0 && $subtotal < $minOrder) {
            return back()->withInput()->withErrors([
                'state' => "Minimum order for {$data['state']} is ₹" . number_format($minOrder, 2)
                         . ". Your cart total is ₹" . number_format($subtotal, 2) . ".",
            ]);
        }

        $total = $subtotal + $packing;

        try {
            $order = DB::transaction(function () use ($data, $cart, $subtotal, $packing, $total) {
                $orderNumber = 'ORD' . time();

                $orderPayload = [];
                if (\Illuminate\Support\Facades\Schema::hasTable('orders')) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'order_number'))    $orderPayload['order_number']    = $orderNumber;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_name'))   $orderPayload['customer_name']   = $data['name'];
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_phone'))  $orderPayload['customer_phone']  = $data['phone'];
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_email'))  $orderPayload['customer_email']  = $data['email'] ?? null;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'customer_address'))$orderPayload['customer_address']= $data['address'];
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'city'))            $orderPayload['city']            = $data['city'];
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'place'))           $orderPayload['place']           = $data['place'] ?? null;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'state'))           $orderPayload['state']           = $data['state'];
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'pincode'))         $orderPayload['pincode']         = $data['pin'] ?? null;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'packing_charges')) $orderPayload['packing_charges'] = $packing;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'total_amount'))    $orderPayload['total_amount']    = $total;
                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'status'))          $orderPayload['status']          = 'pending';
                }

                $order = Order::create($orderPayload);

                foreach ($cart as $productId => $qty) {
                    $product = \App\Models\Product::find($productId);
                    if (! $product) continue;

                    if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
                        if ($product->stock < $qty) {
                            throw new \Exception("Product '" . ($product->name_en ?? $product->name) . "' out of stock (Available: {$product->stock})");
                        }
                        $product->decrement('stock', $qty);
                    }

                    $price     = $product->price ?? $product->rate ?? $product->mrp ?? 0;
                    $itemTotal = $price * $qty;

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $qty,
                        'price'      => $price,
                        'total'      => $itemTotal,
                    ]);
                }

                return $order;
            });
        } catch (\Throwable $ex) {
            logger()->error('Order persist failed', ['error' => $ex->getMessage()]);
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

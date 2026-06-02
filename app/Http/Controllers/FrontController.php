<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        // Get all categories with their active products
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'Active');
        }])->get();
        // Get active banners for the homepage hero slider
        $banners = Banner::where('is_active', true)->latest()->get();
        return view('front.index', compact('categories', 'banners'));
    }

    public function downloadProducts()
    {
        // Strictly Auto-generate PDF based on the active website products
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'Active');
        }])->whereHas('products', function($query) {
            $query->where('status', 'Active');
        })->get();
        
        $company = \App\Models\CompanyDetail::first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('front.products-pdf', compact('categories', 'company'));
        return $pdf->download('CrackerTime_Products_List.pdf');
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function terms()
    {
        $sections = \App\Models\TermsSection::ofType('terms')->get();
        return view('front.terms', compact('sections'));
    }

    public function privacy()
    {
        $sections = \App\Models\TermsSection::ofType('privacy')->get();
        return view('front.privacy', compact('sections'));
    }

    public function checkout()
    {
        $cart = session('cart', []);
        $items = [];
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price = $product->price ?? 0;
            $itemTotal = $price * $qty;
            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'total' => $itemTotal,
            ];
            $subtotal += $itemTotal;
        }

        $packing = 0; // default
        $total = $subtotal + $packing;

        return view('front.checkout', compact('items', 'subtotal', 'packing', 'total'));
    }

    public function blog()
    {
        $posts = [
            [
                'date' => 'Aug 23, 2025',
                'views' => 629,
                'title' => 'The Science Behind the Sparkle: How Firecrackers Create Light, Sound, and Color',
                'excerpt' => "Ever stared in wonder at a fireworks display? There's amazing chemistry and physics at work! Uncover the secrets of how firecrackers produce brilliant light, thunderous sound, and vibrant colors.",
                'slug' => 'science-behind-the-sparkle'
            ],
            [
                'date' => 'Aug 21, 2025',
                'views' => 842,
                'title' => 'Top 10 Eco-Friendly Crackers for a Green Diwali 2025 – Buy Online Safely',
                'excerpt' => 'Light up Diwali 2025 sustainably with our top 10 eco-friendly crackers. Shop low-smoke, biodegradable firecrackers at Crackers for a green celebration.',
                'slug' => 'eco-friendly-crackers-2025'
            ],
            [
                'date' => 'Aug 21, 2025',
                'views' => 855,
                'title' => 'Ultimate Guide to Cracker Safety: Essential Tips for Family Celebrations',
                'excerpt' => 'Ensure a safe Diwali with our ultimate guide to cracker safety. Discover essential tips for family celebrations and shop safe firecrackers online at Crackers.',
                'slug' => 'cracker-safety-guide'
            ],
            [
                'date' => 'Aug 21, 2025',
                'views' => 498,
                'title' => 'The Brilliant History of Firecrackers: From Ancient China to Your Diwali Celebration',
                'excerpt' => "Ever wonder how firecrackers became a Diwali essential? Journey through time from their accidental invention in China to the heart of India's Festival of Lights.",
                'slug' => 'history-of-firecrackers'
            ],
            [
                'date' => 'Aug 21, 2025',
                'views' => 684,
                'title' => '10 Safe & Sparkling Crackers for Kids: The Ultimate 2025 Guide for Worry-Free Diwali Fun',
                'excerpt' => 'Planning a fun and safe Diwali for your little ones? Discover our top 10 kid-friendly crackers that prioritize safety without compromising on the sparkle.',
                'slug' => 'kid-friendly-crackers-2025'
            ],
            [
                'date' => 'Aug 21, 2025',
                'views' => 456,
                'title' => 'How to Budget for Diwali Crackers: Smart Tips to Celebrate More and Spend Less in 2025',
                'excerpt' => 'Want to enjoy a spectacular Diwali without breaking the bank? Learn smart budgeting strategies, discover affordable cracker options, and find the best online deals for a brilliant yet economical celebration.',
                'slug' => 'budget-for-diwali-crackers-2025'
            ],
        ];

        return view('front.blog', compact('posts'));
    }

    public function placeOrder(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:191',
            'address' => 'required|string',
            'city' => 'required|string|max:120',
            'state' => 'required|string|max:120',
            'pin' => 'nullable|string|max:20',
        ]);

        // Compute totals from session cart
        $cart = session('cart', []);
        $subtotal = 0;
        foreach ($cart as $productId => $qty) {
            $product = \App\Models\Product::find($productId);
            if (! $product) continue;
            $price = $product->price ?? 0;
            $subtotal += $price * $qty;
        }

        $packing = 0;
        $total = $subtotal + $packing;

        // Persist order and order items in the database
        try {
            $order = DB::transaction(function () use ($data, $cart, $subtotal, $packing, $total) {
                $orderNumber = 'ORD' . time();

                // Build order payload only for columns that exist in the orders table
                $orderPayload = [];
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

                $order = Order::create($orderPayload);

                foreach ($cart as $productId => $qty) {
                    $product = \App\Models\Product::find($productId);
                    if (! $product) continue;
                    $price = $product->price ?? 0;
                    $itemTotal = $price * $qty;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'total' => $itemTotal,
                    ]);

                    // Decrement stock if column exists
                    if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
                        try { $product->decrement('stock', $qty); } catch (\Throwable $e) { /* ignore */ }
                    }
                }

                return $order;
            });
        } catch (\Throwable $ex) {
            logger()->error('Order persist failed', ['error' => $ex->getMessage(), 'data' => $data, 'cart' => $cart]);
            return redirect()->route('home')->with('error', 'There was a problem placing your order. Please try again.');
        }

        // Clear cart after placing
        session(['cart' => []]);

        return redirect()->route('home')->with('success', 'Order placed successfully. Order no: ' . ($order->order_number ?? ''));
    }

    public function contactSubmit(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'message' => 'required|string',
        ]);

        ContactInquiry::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => $data['message'],
            'status'  => 'unread',
        ]);

        return back()->with('success', 'Thanks for your message — we will get back to you shortly.');
    }
}

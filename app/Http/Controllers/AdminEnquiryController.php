<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminEnquiryController extends Controller
{
    /**
     * Display the Direct Enquiry form (Order Entry)
     */
    public function directEnquiry(Request $request)
    {
        $products = Product::where('status', 'active')->orWhere('status', 1)->get();
        // Get unique customers from existing orders
        $customers = Order::select('customer_name', 'customer_phone', 'customer_address')
            ->whereNotNull('customer_phone')
            ->distinct('customer_phone')
            ->get();
        
        return view('admin.enquiry.direct', compact('products', 'customers'));
    }

    /**
     * Store a new direct order (manual entry)
     */
    public function storeDirect(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'address' => 'required|string',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'final_amount' => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Generate a unique order number for direct entries
                $orderNumber = 'DIR-' . strtoupper(Str::random(8));
                
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_name' => $request->customer_name,
                    'customer_address' => $request->address,
                    'customer_phone' => $request->customer_phone,
                    'total_amount' => $request->final_amount,
                    'status' => 'completed', 
                    'created_at' => $request->order_date . ' ' . date('H:i:s'),
                ]);

                foreach ($request->items as $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['quantity'] * $item['price'],
                    ]);

                    // Decrement stock if column exists
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product && \Illuminate\Support\Facades\Schema::hasColumn('products', 'stock')) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            });

            return redirect()->route('admin.direct.enquiry')->with('success', 'Direct Order created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the Enquiry Customer List
     */
    public function enquiryCustomer(Request $request)
    {
        $type = $request->get('type', 'direct');
        $query = Order::query();

        if ($type === 'direct') {
            $query->where('order_number', 'LIKE', 'DIR-%');
        } else {
            $query->where(function($q) {
                $q->where('order_number', 'NOT LIKE', 'DIR-%')
                  ->orWhereNull('order_number');
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                  ->orWhere('order_number', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.enquiry.customer', compact('orders', 'type'));
    }
    public function exportCustomer(Request $request)
    {
        $type = $request->get('type', 'direct');
        $query = Order::query();

        if ($type === 'direct') {
            $query->where('order_number', 'LIKE', 'DIR-%');
        } else {
            $query->where(function($q) {
                $q->where('order_number', 'NOT LIKE', 'DIR-%')
                  ->orWhereNull('order_number');
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                  ->orWhere('order_number', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->latest()->get();

        $fileName = 'customer_enquiries_' . date('Y-m-d') . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, ['Order ID', 'Date', 'Time', 'Customer Name', 'Phone', 'Status', 'Total Amount']);

            // CSV Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number ?? $order->id,
                    $order->created_at ? $order->created_at->format('Y-m-d') : 'N/A',
                    $order->created_at ? $order->created_at->format('h:i A') : 'N/A',
                    $order->customer_name,
                    $order->customer_phone,
                    $order->status ?? 'Received',
                    $order->total_amount
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

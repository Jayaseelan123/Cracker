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
        // Get unique customers from existing orders — fetch all needed columns
        $customers = Order::select('customer_name', 'customer_phone', 'customer_email', 'customer_address', 'city', 'state', 'pincode')
            ->whereNotNull('customer_phone')
            ->distinct('customer_phone')
            ->get();
            
        // Fetch orders for the enquiry list
        $type = $request->get('type', 'direct');
        $query = Order::with('items.product');

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
        
        if ($request->ajax()) {
            return view('admin.enquiry.customer_list_partial', compact('orders', 'type'))->render();
        }
        
        return view('admin.enquiry.direct', compact('products', 'customers', 'orders', 'type'));
    }

    /**
     * Store a new direct order (manual entry)
     */
    public function storeDirect(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'nullable|email|max:191',
            'address'        => 'required|string',
            'city'           => 'nullable|string|max:120',
            'state'          => 'nullable|string|max:120',
            'pincode'        => 'nullable|string|max:20',
            'country'        => 'nullable|string|max:120',
            'order_date'     => 'required|date',
            'items'          => 'required|array|min:1',
            'final_amount'   => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Generate a unique order number for direct entries
                $orderNumber = 'DIR-' . strtoupper(Str::random(8));
                
                $order = Order::create([
                    'order_number'    => $orderNumber,
                    'customer_name'   => $request->customer_name,
                    'customer_email'  => $request->customer_email ?? null,
                    'customer_address'=> $request->address,
                    'customer_phone'  => $request->customer_phone,
                    'city'            => $request->city ?? null,
                    'state'           => $request->state ?? null,
                    'pincode'         => $request->pincode ?? null,
                    'total_amount'    => $request->final_amount,
                    'packing_charges' => $request->packing_charges ?? 0,
                    'status'          => 'completed',
                    'created_at'      => $request->order_date . ' ' . date('H:i:s'),
                ]);

                // Deduplicate items server-side: collapse any repeated product_id
                // entries by summing their quantities (guards against double-submit bugs)
                $deduped = [];
                foreach ($request->items as $item) {
                    $pid = $item['product_id'];
                    if (!isset($deduped[$pid])) {
                        $deduped[$pid] = [
                            'product_id' => $pid,
                            'quantity'   => 0,
                            'price'      => $item['price'],
                        ];
                    }
                    $deduped[$pid]['quantity'] += (int) $item['quantity'];
                }

                foreach ($deduped as $item) {
                    \App\Models\OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                        'total'      => $item['quantity'] * $item['price'],
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
        $query = Order::with('items.product');

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
        
        if ($request->ajax()) {
            return view('admin.enquiry.customer_list_partial', compact('orders', 'type'))->render();
        }
        
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

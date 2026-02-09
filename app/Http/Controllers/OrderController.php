<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // ... existing code ...
    public function index(Request $request)
    {
        $orders = Order::when($request->status && $request->status != "All", function($query) use ($request){
                        $query->where('status', $request->status);
                    })
                    ->orderBy('id','DESC')
                    ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([ 'status' => 'required|string' ]);
        $order->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    // New method to view order details
    public function view($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.view', compact('order'));
    }

    // New method to download order as PDF
    public function downloadPdf($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.orders.pdf', compact('order'))
            ->setPaper('a4')
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0);
        
        return $pdf->download('Order_' . $order->order_number . '.pdf');
    }
}
@extends('layouts.admin')

@section('content')
<h2>Dashboard</h2>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h2>{{ $totalOrders }}</h2>
            <p>Total Orders</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h2>{{ $pendingOrders }}</h2>
            <p>Pending Orders</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h2>{{ $totalProducts }}</h2>
            <p>Total Products</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center">
            <h2>{{ $categories }}</h2>
            <p>Categories</p>
        </div>
    </div>
</div>

<h4 class="mt-4">Recent Orders</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
   <tbody>
@foreach($recentOrders as $order)
<tr>
    <td>{{ $order->order_number ?? $order->id }}</td>
    <td>{{ $order->customer_name ?? '—' }}</td>

    <td>₹ {{
        $order->amount
        ?? $order->total_amount
        ?? $order->grand_total
        ?? $order->final_amount
        ?? $order->subtotal
        ?? $order->total
        ?? 0
    }}</td>

    <td>{{ $order->status ?? 'Pending' }}</td>

    <td>{{ $order->order_date ?? $order->created_at->format('Y-m-d') }}</td>
</tr>
@endforeach
</tbody>

</table>
@endsection

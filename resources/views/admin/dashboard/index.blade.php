@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Statistics Cards -->
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $totalOrders }}</h3>
                        <p class="mb-0">Total Orders</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $pendingOrders }}</h3>
                        <p class="mb-0">Pending Orders</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $totalProducts }}</h3>
                        <p class="mb-0">Total Products</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $categories }}</h3>
                        <p class="mb-0">Categories</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h4 class="mb-0">Recent Orders</h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->customer_name ?? '—' }}</td>
                                    <td>₹ {{ number_format($order->total_amount ?? 0, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ ($order->status ?? 'pending') == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $order->created_at ? $order->created_at->format('d-m-Y') : '—' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.view', $order->id) }}"
                                            class="btn btn-sm btn-primary w-100">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
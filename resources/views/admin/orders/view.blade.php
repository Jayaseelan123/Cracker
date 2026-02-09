@extends('layouts.admin')

@section('content')

<style>
/* ---------------- GLOBAL PAGE STYLES ---------------- */
.order-view-container {
    padding: 25px;
    background: #f4f6fb;
}

/* ---------------- HEADER SECTION ---------------- */
.order-header {
    background: linear-gradient(135deg, #6a5acd, #836fff);
    padding: 35px;
    border-radius: 14px;
    margin-bottom: 35px;
    color: white;
    box-shadow: 0 6px 20px rgba(80, 80, 170, 0.25);
}

.order-number-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
}

/* ---------------- STATUS BADGE ---------------- */
.status-badge {
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* ---------------- BEAUTIFUL CARD ---------------- */
.info-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 14px;
    border: 1px solid #e3e3e3;
    margin-bottom: 25px;
    backdrop-filter: blur(4px);
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    overflow: hidden;
}

.info-card-header {
    background: linear-gradient(135deg, #6a5acd, #8a7eff);
    color: white;
    padding: 14px 18px;
    font-weight: 700;
    font-size: 17px;
    letter-spacing: 0.3px;
}

.info-card-body {
    padding: 22px;
}

.info-row {
    padding: 12px 0;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dashed #ddd;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 700;
    color: #444;
    font-size: 15px;
}

.info-value {
    font-size: 15px;
    color: #555;
}

/* ---------------- ORDER ITEMS TABLE ---------------- */
.items-title {
    font-size: 22px;
    font-weight: 800;
    color: #333;
    margin-bottom: 15px;
    border-left: 6px solid #6a5acd;
    padding-left: 12px;
}

.table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

.table thead {
    background: #6a5acd;
    color: white;
    font-size: 15px;
}

.table thead th {
    padding: 16px !important;
    font-weight: 600;
}

.table tbody tr {
    transition: background 0.15s ease;
}

.table tbody tr:hover {
    background: #f7f5ff;
}

.table td {
    padding: 16px !important;
    font-size: 15px;
    vertical-align: middle !important;
}

/* ---------------- TOTAL BOX ---------------- */
.total-section {
    display: flex;
    justify-content: flex-end;
    margin-top: 35px;
}

.grand-total-box {
    background: white;
    padding: 25px 35px;
    border-radius: 14px;
    box-shadow: 0 5px 16px rgba(0,0,0,0.1);
    border-top: 5px solid #6a5acd;
    min-width: 320px;
}

.grand-total-label {
    font-size: 15px;
    font-weight: 600;
    color: #666;
}

.grand-total-amount {
    font-size: 36px;
    font-weight: 800;
    color: #6a5acd;
    margin-top: 8px;
}
</style>

<div class="order-view-container">

    <!-- HEADER -->
    <div class="order-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div class="order-number-title">Order #{{ $order->order_number }}</div>
                <div style="font-size: 15px; opacity: 0.9;">Order Details & Invoice Summary</div>
            </div>

            <div>
                <span class="status-badge 
                    @if($order->status == 'pending') bg-warning text-dark
                    @elseif($order->status == 'processing') bg-info text-white
                    @elseif($order->status == 'completed') bg-success text-white
                    @elseif($order->status == 'cancelled') bg-danger text-white
                    @else bg-secondary text-white
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Customer Details -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-header">Customer Details</div>
                <div class="info-card-body">
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $order->customer_phone ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $order->customer_email ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Details -->
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-header">Shipping Address</div>
                <div class="info-card-body">
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $order->customer_address ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">City:</span>
                        <span class="info-value">{{ $order->city ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Place:</span>
                        <span class="info-value">{{ $order->place ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ITEMS SECTION -->
    <div class="items-section">
        <div class="items-title">Order Items</div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th style="text-align:center;">Quantity</th>
                        <th style="text-align:right;">Price (Rs.)</th>
                        <th style="text-align:right;">Total (Rs.)</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name_en ?? $item->product->name ?? 'N/A' }}</td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">Rs. {{ number_format($item->price, 2) }}</td>
                        <td style="text-align:right; font-weight:600;">Rs. {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No items found</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <!-- TOTAL -->
    <div class="total-section">
        <div class="grand-total-box">
            <div class="grand-total-label">TOTAL AMOUNT</div>
            <div class="grand-total-amount">Rs. {{ number_format($order->total_amount, 2) }}</div>
        </div>
    </div>

</div>

@endsection

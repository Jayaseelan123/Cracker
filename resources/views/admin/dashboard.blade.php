@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@push('head')
<style>
    .card-plain {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 6px 20px rgba(20,30,50,0.06);
        border: 1px solid #eef2f6;
    }
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-count {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.2;
        color: #333;
    }
    .stat-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        margin-top: 4px;
    }
    .table thead th {
        border-bottom: 1px solid #eef2f6;
        font-weight: 600;
        color: #6b7280;
        background: #f8f9fa;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .table td {
        vertical-align: middle;
        font-size: 14px;
        color: #444;
    }
    .order-number {
        font-weight: 700;
        color: #6f42c1;
    }
    .badge-pending {
        background: #fff3cd;
        color: #856404;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-completed {
        background: #d1e7dd;
        color: #0f5132;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <div class="row g-4">
        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div class="stat-icon" style="background:#e8f1ff; color:#0d6efd;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <div class="stat-count" data-count>{{ $totalOrders ?? $totalOrdersCount ?? 0 }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
        </div>
        <!-- Pending Orders -->
        <div class="col-md-3">
            <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div class="stat-icon" style="background:#fff7e6; color:#fd7e14;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="stat-count" data-count>{{ $pendingOrders ?? 0 }}</div>
                    <div class="stat-label">Pending Orders</div>
                </div>
            </div>
        </div>
        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div class="stat-icon" style="background:#e9fff0; color:#198754;">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <div class="stat-count" data-count>{{ $totalProducts ?? 0 }}</div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>
        </div>
        <!-- Categories -->
        <div class="col-md-3">
            <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div class="stat-icon" style="background:#f4ecff; color:#6f42c1;">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <div class="stat-count" data-count>{{ $totalCategories ?? $categories ?? 0 }}</div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-plain">
    <h5 class="mb-4 fw-bold" style="color:#333;">Recent Orders</h5>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
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
                @if(!empty($recentOrders) && $recentOrders->count())
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order->id ?? 0) }}" class="order-number text-decoration-none">
                                    {{ $order->order_number ?? ('ORD-' . ($order->id ?? '')) }}
                                </a>
                            </td>
                            <td class="fw-medium">{{ optional($order->user)->name ?? $order->customer_name ?? '—' }}</td>
                            <td class="fw-bold">₹{{ number_format((float)($order->total ?? 0), 2) }}</td>
                            <td>
                                @if(strtolower($order->status ?? 'pending') == 'completed' || strtolower($order->status ?? '') == 'delivered')
                                    <span class="badge-completed">{{ ucfirst($order->status) }}</span>
                                @else
                                    <span class="badge-pending">{{ ucfirst($order->status ?? 'pending') }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ optional($order->created_at)->format('M d, Y') ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                    @for($i=0;$i<5;$i++)
                        <tr>
                            <td class="order-number">ORD-20261020{{ rand(1000,9999) }}</td>
                            <td class="fw-medium">Sample Customer</td>
                            <td class="fw-bold">₹{{ number_format(rand(1000,9000)) }}</td>
                            <td><span class="badge-pending">Pending</span></td>
                            <td class="text-muted">{{ now()->subDays($i)->format('M d, Y') }}</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function animateCounters() {
        document.querySelectorAll('[data-count]').forEach(function(el) {
            var target = parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
            var start = 0;
            var duration = 900;
            var startTs = null;
            function step(ts) {
                if (!startTs) startTs = ts;
                var progress = Math.min((ts - startTs) / duration, 1);
                var val = Math.floor(progress * (target - start) + start);
                el.textContent = val.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    el.textContent = target.toLocaleString();
                }
            }
            window.requestAnimationFrame(step);
        });
    }
    animateCounters();
});
</script>
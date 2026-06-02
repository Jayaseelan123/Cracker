@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Online Orders</h2>
                    <p class="text-muted mb-0">Manage and track customer orders</p>
                </div>
                <div class="d-flex align-items-center">
                    <form method="GET" class="d-flex align-items-center">
                        <label class="me-2 text-muted fw-bold small">Filter Status:</label>
                        <select name="status" class="form-select shadow-sm" style="width: 180px;" onchange="this.form.submit()">
                            <option value="All" {{ request('status')=='All' ? 'selected' : '' }}>All Orders</option>
                            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">S.No</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($orders as $order)
        <tr>
            <td class="ps-4">{{ $orders->firstItem() + $loop->index }}</td>
        <td>{{ $order->order_number }}</td>
        <td>
            <div class="fw-bold">{{ $order->customer_name }}</div>
            <div class="small text-muted">
                <i class="fas fa-phone-alt me-1"></i> {{ $order->customer_phone ?? '-' }}<br>
                <i class="fas fa-envelope me-1"></i> {{ $order->customer_email ?? '-' }}<br>
                <i class="fas fa-map-marker-alt me-1"></i> {{ $order->place ?? '-' }}, {{ $order->city ?? '-' }}
            </div>
        </td>
        <td class="text-success">₹{{ number_format($order->total_amount) }}</td>
        <td>
            <select class="form-select status-update {{ $order->status=='completed' ? 'status-active' : ($order->status=='cancelled' ? 'status-inactive' : 'status-pending') }}" data-id="{{ $order->id }}">
                <option value="pending" {{ $order->status=="pending" ? 'selected':'' }}>pending</option>
                <option value="processing" {{ $order->status=="processing" ? 'selected':'' }}>processing</option>
                <option value="completed" {{ $order->status=="completed" ? 'selected':'' }}>completed</option>
                <option value="cancelled" {{ $order->status=="cancelled" ? 'selected':'' }}>cancelled</option>
            </select>
        </td>
        </td>

                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.orders.view', $order->id) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="View Order">
                                <i class="fas fa-eye" style="font-size: 1.1rem;"></i>
                            </a>
                            <a href="{{ route('admin.orders.pdf', $order->id) }}" class="btn btn-outline-info d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="Download PDF">
                                <i class="fas fa-file-pdf" style="font-size: 1.1rem;"></i>
                            </a>
                            @if($order->customer_phone)
                            <a href="https://wa.me/+91{{ $order->customer_phone }}" target="_blank" class="btn btn-outline-success d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="WhatsApp Customer">
                                <i class="fab fa-whatsapp" style="font-size: 1.1rem;"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $orders->appends(request()->input())->links('pagination::bootstrap-5') }}
</div>
</div>

<style>
    .custom-table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .status-update {
        width: 130px;
        font-size: 0.78rem;
        font-weight: 700;
        border-radius: 50px;
        padding: 5px 12px;
        cursor: pointer;
        outline: none !important;
        box-shadow: none !important;
        transition: opacity 0.15s ease;
    }
    .status-update:hover { opacity: 0.82; }

    .status-active { background-color: #dcfce7; color: #15803d; border: 2px solid #86efac; }
    .status-inactive { background-color: #fee2e2; color: #b91c1c; border: 2px solid #fca5a5; }
    .status-pending { background-color: #fef9c3; color: #854d0e; border: 2px solid #fde047; }
</style>

<script>
document.querySelectorAll('.status-update').forEach(select => {
    select.addEventListener('change', function () {
        const newStatus = this.value;
        
        // Update appearance
        this.className = 'form-select status-update ' + 
            (newStatus === 'completed' ? 'status-active' : (newStatus === 'cancelled' ? 'status-inactive' : 'status-pending'));

        fetch(`/admin/orders/${this.dataset.id}/status`, {
            method: "POST",
            headers:{
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({status:this.value})
        });
    });
});
</script>
@endsection
@extends('layouts.admin')

@section('header', 'Enquiry Customer List')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Customer Enquiries</h2>
                    <p class="text-muted mb-0">Manage and track all customer product enquiries</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-white shadow-sm border" onclick="window.print()">
                        <i class="fas fa-print me-2 text-primary"></i>Print List
                    </button>
                    <a href="{{ route('admin.enquiry.customer.export', request()->query()) }}" class="btn btn-success shadow-sm border-0 px-4">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row (Optional but adds premium feel) -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-white bg-opacity-25 rounded-3 p-3 me-3">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <div class="small opacity-75">Total Enquiry Customer</div>
                        <div class="h4 fw-bold mb-0">{{ $orders->total() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- More stats can be added if backend provides them -->
    </div>

    <ul class="nav nav-pills mb-4" id="enquiry-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-pill px-4 py-2 {{ $type === 'direct' ? 'active shadow-sm' : 'bg-white text-muted border' }}" 
               href="{{ route('admin.enquiry.customer', ['type' => 'direct', 'search' => request('search')]) }}">
                <i class="fas fa-store me-2"></i>Direct Enquiries
            </a>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <a class="nav-link rounded-pill px-4 py-2 {{ $type === 'online' ? 'active shadow-sm' : 'bg-white text-muted border' }}" 
               href="{{ route('admin.enquiry.customer', ['type' => 'online', 'search' => request('search')]) }}">
                <i class="fas fa-globe me-2"></i>Online Enquiries
            </a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="customerDataContainer">
        <div class="card-header bg-white border-bottom py-4 px-4">
            <form action="{{ route('admin.enquiry.customer') }}" method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="col-md-5">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control form-control-lg ps-5 border-light-subtle bg-light bg-opacity-50" 
                               placeholder="Search by customer name or mobile..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                            <i class="fas fa-filter me-2"></i>Apply Filter
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.enquiry.customer', ['type' => $type]) }}" class="btn btn-light btn-lg px-4 border">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-table">
                    <thead>
                        <tr>
                            <th class="ps-4">S.No</th>
                            <th>Enquiry Details</th>
                            <th>Customer Profile</th>
                            <th>Status</th>
                            <th class="text-end pe-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-medium">{{ $orders->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $order->created_at->format('d M, Y') }}</span>
                                    <span class="text-muted small"><i class="far fa-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold">
                                        {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $order->customer_name }}</span>
                                        <span class="text-muted small"><i class="fas fa-phone-alt me-1"></i>{{ $order->customer_phone }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select class="form-select status-update-enquiry {{ $order->status=='completed' ? 'badge-soft-success' : 'badge-soft-warning' }}" 
                                        data-id="{{ $order->id }}" style="width: 130px; font-size: 0.85rem; border-radius: 50px;">
                                    <option value="pending" {{ $order->status=="pending" ? 'selected':'' }}>Pending</option>
                                    <option value="processing" {{ $order->status=="processing" ? 'selected':'' }}>Processing</option>
                                    <option value="completed" {{ $order->status=="completed" ? 'selected':'' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status=="cancelled" ? 'selected':'' }}>Cancelled</option>
                                </select>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-light-danger delete-btn" title="Delete Enquiry">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="fas fa-users-slash text-muted opacity-25 fa-4x"></i>
                                    </div>
                                    <h4 class="text-dark">No Customers Found</h4>
                                    <p class="text-muted">We couldn't find any enquiry records matching your criteria.</p>
                                    @if(request('search'))
                                        <a href="{{ route('admin.enquiry.customer', ['type' => $type]) }}" class="btn btn-primary mt-3">Reset Search</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $orders->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
    :root {
        --primary-color: #6366f1;
        --success-color: #10b981;
        --bg-soft-primary: #eef2ff;
        --bg-soft-success: #ecfdf5;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .btn-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .custom-table thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.025em;
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f1f5f9;
        transform: translateY(-1px);
    }

    .custom-table td {
        padding: 1.25rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .search-box {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
    }

    .badge-soft-success {
        background-color: var(--bg-soft-success);
        color: var(--success-color);
        padding: 0.5em 1em;
        font-weight: 500;
        border-radius: 9999px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-light-primary {
        background-color: var(--bg-soft-primary);
        color: var(--primary-color);
        border: none;
    }
    .btn-light-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-light-success {
        background-color: var(--bg-soft-success);
        color: var(--success-color);
        border: none;
    }
    .btn-light-success:hover {
        background-color: var(--success-color);
        color: white;
    }

    .btn-white {
        background: white;
        color: #334155;
    }

    .card {
        border: none;
    }

    @media print {
        .btn, form, .card-footer, .navbar, .sidebar {
            display: none !important;
        }
        .container-fluid { width: 100% !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>


@endsection

@push('scripts')
<script>
document.querySelectorAll('.status-update-enquiry').forEach(select => {
    select.addEventListener('change', function () {
        const orderId = this.dataset.id;
        const newStatus = this.value;
        
        // Visual feedback
        this.className = 'form-select status-update-enquiry ' + 
            (newStatus === 'completed' ? 'badge-soft-success' : 'badge-soft-warning');

        fetch(`/admin/orders/${orderId}/status`, {
            method: "POST",
            headers:{
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({status: newStatus})
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  // Optional: Show toast
              }
          });
    });
});
</script>
@endpush

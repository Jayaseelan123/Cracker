<div id="enquiry-list-wrapper">
    <!-- Stats Row (Optional but adds premium feel) -->
    <div class="row mt-5 mb-4 border-top pt-5" id="order-enquiries-section">
        <div class="col-12">
            <h3 class="fw-bold text-dark mb-4">Order Enquiries</h3>
        </div>
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

    <ul class="nav nav-pills mb-4 gap-2" id="enquiry-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-pill px-4 py-2 {{ $type === 'direct' ? 'active shadow-sm' : 'bg-white text-muted border' }}" 
               href="{{ request()->url() }}?type=direct&search={{ request('search') }}#order-enquiries-section">
                <i class="fas fa-store me-2"></i>Direct Enquiries
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-pill px-4 py-2 {{ $type === 'online' ? 'active shadow-sm' : 'bg-white text-muted border' }}" 
               href="{{ request()->url() }}?type=online&search={{ request('search') }}#order-enquiries-section">
                <i class="fas fa-globe me-2"></i>Online Enquiries
            </a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="customerDataContainer">
        <div class="card-header bg-white border-bottom py-4 px-4">
            <form action="{{ request()->url() }}#order-enquiries-section" method="GET" class="row g-3 align-items-center">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="col-12 col-md-5">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control form-control-lg ps-5 border-light-subtle bg-light bg-opacity-50" 
                               placeholder="Search by customer name or mobile..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg px-4 shadow-sm">
                            <i class="fas fa-filter me-2"></i>Apply Filter
                        </button>
                        @if(request('search'))
                            <a href="{{ request()->url() }}?type={{ $type }}#order-enquiries-section" class="btn btn-light btn-lg px-4 border">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <!-- Desktop Table -->
            <div class="d-none d-md-block">
                <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-table">
                    <thead>
                        <tr>
                            <th class="ps-4">S.No</th>
                            <th>Enquiry Details</th>
                            <th>Customer Profile</th>
                            <th>Total Amount</th>
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
                                @php
                                    $validItems = $order->items->filter(function($item) { return !is_null($item->product); });
                                    $productTotal = (float) $validItems->sum('total');
                                    $pack = (float) ($order->packing_charges ?? 0);
                                    $actualTotal = round($productTotal + $pack);
                                @endphp
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-primary">₹{{ number_format($actualTotal, 2) }}</span>
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
                                @php
                                    $validItems = $order->items->filter(function ($item) {
                                        return !is_null($item->product);
                                    });
                                    $productTotal = (float) $validItems->sum('total');
                                    $pack = (float) ($order->packing_charges ?? 0);
                                    $actualTotal = round($productTotal + $pack);

                                    $waText = "Hello " . $order->customer_name . ",\n\n";
                                    $waText .= "Here are your order details (Order No: " . $order->order_number . "):\n\n";
                                    foreach($validItems as $index_wa => $item) {
                                        $prodName = $item->product->name_en ?? $item->product->name ?? 'Product';
                                        $waText .= ($index_wa + 1) . ". " . $prodName . " - " . $item->quantity . " x Rs." . number_format($item->price) . " = Rs." . number_format($item->total) . "\n";
                                    }
                                    if($pack > 0) {
                                        $waText .= "\nPacking Charges: Rs." . number_format($pack);
                                    }
                                    $waText .= "\nTotal Amount: Rs." . number_format($actualTotal) . "\n\n";
                                    $waText .= "Thank you!";
                                    $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                    if(strlen($phone) == 10) { $phone = '91' . $phone; }
                                    $waUrl = "https://wa.me/" . $phone . "?text=" . urlencode($waText);
                                @endphp
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.orders.view', $order->id) }}" class="btn btn-icon btn-light-primary" title="View Enquiry">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->customer_phone)
                                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-icon btn-light-success" title="WhatsApp Chat">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    @endif
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
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="fas fa-users-slash text-muted opacity-25 fa-4x"></i>
                                    </div>
                                    <h4 class="text-dark">No Customers Found</h4>
                                    <p class="text-muted">We couldn't find any enquiry records matching your criteria.</p>
                                    @if(request('search'))
                                        <a href="{{ request()->url() }}?type={{ $type }}#order-enquiries-section" class="btn btn-primary mt-3">Reset Search</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>

            <!-- Mobile Cards -->
            <div class="d-block d-md-none p-3 bg-light">
                @forelse($orders as $index => $order)
                @php
                    $validItems = $order->items->filter(function ($item) {
                        return !is_null($item->product);
                    });
                    $productTotal = (float) $validItems->sum('total');
                    $pack = (float) ($order->packing_charges ?? 0);
                    $actualTotal = round($productTotal + $pack);

                    $waText = "Hello " . $order->customer_name . ",\n\n";
                    $waText .= "Here are your order details (Order No: " . $order->order_number . "):\n\n";
                    foreach($validItems as $index_wa => $item) {
                        $prodName = $item->product->name_en ?? $item->product->name ?? 'Product';
                        $waText .= ($index_wa + 1) . ". " . $prodName . " - " . $item->quantity . " x Rs." . number_format($item->price) . " = Rs." . number_format($item->total) . "\n";
                    }
                    if($pack > 0) {
                        $waText .= "\nPacking Charges: Rs." . number_format($pack);
                    }
                    $waText .= "\nTotal Amount: Rs." . number_format($actualTotal) . "\n\n";
                    $waText .= "Thank you!";
                    $phone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                    if(strlen($phone) == 10) { $phone = '91' . $phone; }
                    $waUrl = "https://wa.me/" . $phone . "?text=" . urlencode($waText);
                @endphp
                <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted fw-bold" style="font-size:0.85rem;">S.No: {{ $orders->firstItem() + $index }}</span>
                            <div class="text-end">
                                <div class="fw-bold text-dark" style="font-size:0.85rem;">{{ $order->created_at->format('d M, Y') }}</div>
                                <div class="text-muted small"><i class="far fa-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm me-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark fs-6">{{ $order->customer_name }}</span>
                                <span class="text-muted small mt-1"><i class="fas fa-phone-alt me-1 text-primary"></i>{{ $order->customer_phone }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div class="text-muted" style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Total Amount</div>
                            <div class="fw-bold text-primary fs-5">₹{{ number_format($order->total_amount, 2) }}</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted" style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Status</div>
                            <select class="form-select status-update-enquiry {{ $order->status=='completed' ? 'badge-soft-success' : 'badge-soft-warning' }}" 
                                    data-id="{{ $order->id }}" style="width: 130px; font-size: 0.85rem; border-radius: 50px;">
                                <option value="pending" {{ $order->status=="pending" ? 'selected':'' }}>Pending</option>
                                <option value="processing" {{ $order->status=="processing" ? 'selected':'' }}>Processing</option>
                                <option value="completed" {{ $order->status=="completed" ? 'selected':'' }}>Completed</option>
                                <option value="cancelled" {{ $order->status=="cancelled" ? 'selected':'' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top mt-2 flex-wrap">
                            <a href="{{ route('admin.orders.view', $order->id) }}" class="btn btn-outline-primary flex-fill rounded-3 fw-bold" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-eye me-2"></i> View
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="flex-fill d-flex m-0">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger w-100 rounded-3 delete-btn fw-bold" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                </button>
                            </form>
                            @if($order->customer_phone)
                            <a href="{{ $waUrl }}" target="_blank" class="btn btn-outline-success w-100 rounded-3 fw-bold mt-2" style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                <i class="fab fa-whatsapp me-2"></i> WhatsApp
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="py-5">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-users-slash text-muted opacity-25 fa-4x"></i>
                        </div>
                        <h4 class="text-dark">No Customers Found</h4>
                        <p class="text-muted">We couldn't find any enquiry records matching your criteria.</p>
                        @if(request('search'))
                            <a href="{{ request()->url() }}?type={{ $type }}#order-enquiries-section" class="btn btn-primary mt-3">Reset Search</a>
                        @endif
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $orders->appends(request()->input())->fragment('order-enquiries-section')->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .custom-table thead th {
        background-color: #f8fafc; color: #64748b; font-weight: 600; text-transform: uppercase;
        font-size: 0.75rem; letter-spacing: 0.025em; padding: 1rem 0.75rem; border-bottom: 1px solid #e2e8f0;
    }
    .custom-table tbody tr { transition: all 0.2s ease; }
    .custom-table tbody tr:hover { background-color: #f1f5f9; transform: translateY(-1px); }
    .custom-table td { padding: 1.25rem 0.75rem; border-bottom: 1px solid #f1f5f9; }
    .search-box { position: relative; }
    .search-icon { position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .avatar-sm { width: 40px; height: 40px; font-size: 0.875rem; }
    .badge-soft-success { background-color: #ecfdf5; color: #10b981; padding: 0.5em 1em; font-weight: 500; border-radius: 9999px; }
    .badge-soft-warning { background-color: #fffbeb; color: #f59e0b; padding: 0.5em 1em; font-weight: 500; border-radius: 9999px; }
    .btn-icon { width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; }
    .btn-light-primary { background-color: #eef2ff; color: #6366f1; border: none; }
    .btn-light-primary:hover { background-color: #6366f1; color: white; }
    .btn-light-success { background-color: #ecfdf5; color: #10b981; border: none; }
    .btn-light-success:hover { background-color: #10b981; color: white; }
</style>

@push('scripts')
<script>
// Status update AJAX
document.addEventListener('change', function(e) {
    if (e.target.matches('.status-update-enquiry')) {
        const select = e.target;
        const orderId = select.dataset.id;
        const newStatus = select.value;
        select.className = 'form-select status-update-enquiry ' + 
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
          .catch(() => { /* silently ignore network errors */ });
    }
});

// Delete confirmation
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;
    e.preventDefault();
    const form = btn.closest('form');
    if (!form) return;

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete Enquiry?',
            text: 'This will permanently remove this enquiry and all its items. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    } else {
        if (confirm('Delete this enquiry? This cannot be undone.')) form.submit();
    }
});

// AJAX handling for tabs, pagination, and search form to prevent page jump/reload
document.addEventListener('click', function(e) {
    // Check if it's a tab link, pagination link, or reset search link
    const link = e.target.closest('#enquiry-tabs a.nav-link') || 
                 e.target.closest('.pagination a') || 
                 (e.target.closest('a.btn') && e.target.closest('a.btn').textContent.includes('Reset Search')) ||
                 (e.target.closest('a.btn-light') && e.target.closest('a.btn-light').querySelector('.fa-times'));
                 
    if (link && link.href) {
        // Exclude export excel links or view links
        if(link.href.includes('export') || link.href.includes('orders/') || link.target === '_blank') return;
        
        e.preventDefault();
        loadEnquiries(link.href);
    }
});

document.addEventListener('submit', function(e) {
    const form = e.target.closest('#customerDataContainer form');
    if (form) {
        e.preventDefault();
        const url = new URL(form.action);
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        url.search = params.toString();
        loadEnquiries(url.toString());
    }
});

function loadEnquiries(url) {
    const container = document.getElementById('enquiry-list-wrapper');
    if(container) {
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';
    }

    fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => response.text())
    .then(html => {
        if(container) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('enquiry-list-wrapper');
            if (newContent) {
                container.innerHTML = newContent.innerHTML;
            }
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            
            // Push state to browser history to update the URL without reload
            window.history.pushState({}, '', url);
        }
    })
    .catch(() => {
        // Fallback to normal navigation if AJAX fails
        window.location.href = url;
    });
}
</script>
@endpush

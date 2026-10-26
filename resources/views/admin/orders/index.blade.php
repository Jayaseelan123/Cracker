@extends('layouts.admin')

@section('title', 'Online Orders')
@section('header', 'Online Orders')

@section('content')
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Online Orders</h2>
                        <p class="text-muted mb-0">Manage and track customer orders</p>
                    </div>
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        {{-- Search --}}
                        <form method="GET" id="orderFilterForm"
                            class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 flex-wrap">
                            <input type="hidden" name="status" value="{{ request('status', 'All') }}">
                            <div class="d-flex w-100 flex-grow-1 gap-2">
                                <input type="text" name="search" id="orderSearchInput"
                                    class="form-control order-search-input flex-grow-1"
                                    placeholder="Search order / customer..." value="{{ request('search') }}"
                                    autocomplete="off">
                                <button type="submit" class="btn btn-primary order-search-btn px-3 text-nowrap">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('orders.index') }}" class="btn order-reset-btn px-3 text-nowrap"
                                    title="Reset">
                                    <i class="fas fa-sync-alt me-1"></i>Reset
                                </a>
                            </div>
                        </form>

                        {{-- Status Filter --}}
                        <form method="GET" id="statusFilterForm" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <label class="text-muted fw-bold small mb-0">Status:</label>
                            <select name="status" class="form-select order-status-filter" onchange="this.form.submit()">
                                <option value="All" {{ request('status', 'All') == 'All' ? 'selected' : '' }}>All Orders
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Session Flash --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Status update toast --}}
        <div id="statusToast" class="position-fixed top-0 end-0 p-3" style="z-index: 9999; display:none;">
            <div class="toast show align-items-center border-0 shadow" id="statusToastInner" role="alert">
                <div class="d-flex">
                    <div class="toast-body fw-semibold" id="statusToastMsg">Status updated!</div>
                    <button type="button" class="btn-close me-2 m-auto"
                        onclick="document.getElementById('statusToast').style.display='none'"></button>
                </div>
            </div>
        </div>

        {{-- Active filters info --}}
        @if(request('search') || (request('status') && request('status') !== 'All'))
            <div class="alert border-0 rounded-3 mb-4 px-4 py-3 d-flex align-items-center justify-content-between"
                style="background:#eff6ff; border-left: 4px solid #0d6efd !important;">
                <div>
                    <i class="fas fa-filter me-2 text-primary"></i>
                    <strong>{{ $orders->total() }}</strong> order{{ $orders->total() !== 1 ? 's' : '' }} found
                    @if(request('search'))
                        for <span
                            class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 ms-1">&ldquo;{{ request('search') }}&rdquo;</span>
                    @endif
                    @if(request('status') && request('status') !== 'All')
                        &mdash; Status: <span
                            class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2">{{ ucfirst(request('status')) }}</span>
                    @endif
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-sm order-reset-btn">
                    <i class="fas fa-times me-1"></i>Clear Filters
                </a>
            </div>
        @endif

        {{-- Orders Table --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            @if($orders->count() > 0)
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">S.No</th>
                                    <th>Order No</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4"><i class="fas fa-bolt me-1 text-warning"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="ps-4 fw-medium text-muted">{{ $orders->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $order->order_number }}</div>
                                            <div class="text-muted small">
                                                {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $order->customer_name }}</div>
                                            <div class="small text-muted">
                                                @if($order->customer_phone)
                                                    <i class="fas fa-phone-alt me-1"></i>{{ $order->customer_phone }}<br>
                                                @endif
                                                @if($order->customer_email)
                                                    <i class="fas fa-envelope me-1"></i>{{ $order->customer_email }}<br>
                                                @endif
                                                @if($order->place || $order->city)
                                                    <i
                                                        class="fas fa-map-marker-alt me-1"></i>{{ $order->place ?? '' }}{{ ($order->place && $order->city) ? ', ' : '' }}{{ $order->city ?? '' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $validItems = $order->items->filter(function ($item) {
                                                    return !is_null($item->product);
                                                });
                                                $productTotal = (float) $validItems->sum('total');
                                                $pack = (float) ($order->packing_charges ?? 0);
                                                $actualTotal = round($productTotal + $pack);

                                                $waText = "Hello " . $order->customer_name . ",\n\n";
                                                $waText .= "Here are your order details (Order No: " . $order->order_number . "):\n\n";
                                                foreach($validItems as $index => $item) {
                                                    $prodName = $item->product->name_en ?? $item->product->name ?? 'Product';
                                                    $waText .= ($index + 1) . ". " . $prodName . " - " . $item->quantity . " x Rs." . number_format($item->price) . " = Rs." . number_format($item->total) . "\n";
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
                                            <span class="fw-bold text-success">₹{{ number_format($actualTotal) }}</span>
                                        </td>
                                        <td>
                                            <select
                                                class="form-select status-update {{ $order->status == 'completed' ? 'status-active' : ($order->status == 'cancelled' ? 'status-inactive' : 'status-pending') }}"
                                                data-id="{{ $order->id }}">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                    Processing</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('admin.orders.view', $order->id) }}"
                                                    class="action-pill action-pill-view" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                    <span>View</span>
                                                </a>

                                                @if($order->customer_phone)
                                                    <a href="{{ $waUrl }}" target="_blank"
                                                        class="action-pill action-pill-whatsapp" title="WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                        <span>Chat</span>
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

                <!-- Mobile Cards -->
                <div class="d-block d-md-none p-3 bg-light">
                    @foreach($orders as $order)
                        @php
                            $validItems = $order->items->filter(function ($item) {
                                return !is_null($item->product);
                            });
                            $productTotal = (float) $validItems->sum('total');
                            $pack = (float) ($order->packing_charges ?? 0);
                            $actualTotal = round($productTotal + $pack);

                            $waText = "Hello " . $order->customer_name . ",\n\n";
                            $waText .= "Here are your order details (Order No: " . $order->order_number . "):\n\n";
                            foreach($validItems as $index => $item) {
                                $prodName = $item->product->name_en ?? $item->product->name ?? 'Product';
                                $waText .= ($index + 1) . ". " . $prodName . " - " . $item->quantity . " x Rs." . number_format($item->price) . " = Rs." . number_format($item->total) . "\n";
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
                                    <div class="fw-bold text-dark fs-5">{{ $order->order_number }}</div>
                                    <span class="text-success fw-bold fs-6">₹{{ number_format($order->total_amount) }}</span>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small fw-bold text-uppercase mb-1"><i class="far fa-clock me-1"></i> Date
                                    </div>
                                    <div class="fw-semibold text-dark">
                                        {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : '—' }}
                                    </div>
                                </div>

                                <div class="mb-3 bg-light rounded-3 p-2">
                                    <div class="text-muted small fw-bold text-uppercase mb-1"><i class="fas fa-user me-1"></i>
                                        Customer Details</div>
                                    <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                                    <div class="small text-muted mt-1">
                                        @if($order->customer_phone)
                                            <i class="fas fa-phone-alt me-1 text-primary"></i>{{ $order->customer_phone }}<br>
                                        @endif
                                        @if($order->customer_email)
                                            <i class="fas fa-envelope me-1 text-primary"></i>{{ $order->customer_email }}<br>
                                        @endif
                                        @if($order->place || $order->city)
                                            <i
                                                class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $order->place ?? '' }}{{ ($order->place && $order->city) ? ', ' : '' }}{{ $order->city ?? '' }}
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-muted"
                                        style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Status</div>
                                    <select
                                        class="form-select status-update {{ $order->status == 'completed' ? 'status-active' : ($order->status == 'cancelled' ? 'status-inactive' : 'status-pending') }}"
                                        data-id="{{ $order->id }}"
                                        style="width:130px; font-size:0.8rem; padding:6px 12px; height:auto;">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                        </option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2 pt-3 border-top mt-2 flex-wrap">
                                    <a href="{{ route('admin.orders.view', $order->id) }}"
                                        class="btn btn-outline-primary flex-fill rounded-3 fw-bold action-pill-view"
                                        style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-eye me-2"></i> View
                                    </a>

                                    @if($order->customer_phone)
                                        <a href="{{ $waUrl }}" target="_blank"
                                            class="btn btn-outline-success w-100 rounded-3 fw-bold mt-2 action-pill-whatsapp"
                                            style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-center">
                    {{ $orders->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>

            @else
                {{-- Empty state --}}
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted opacity-25 mb-3 d-block"></i>
                    @if(request('search') || (request('status') && request('status') !== 'All'))
                        <h4 class="text-dark">No Orders Found</h4>
                        <p class="text-muted">No orders match your current filters.</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-primary mt-2 px-4">
                            <i class="fas fa-sync-alt me-2"></i>Clear Filters
                        </a>
                    @else
                        <h4 class="text-dark">No Orders Yet</h4>
                        <p class="text-muted">Customer orders will appear here once placed.</p>
                    @endif
                </div>
            @endif
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

        /* Search input */
        .order-search-input {
            width: 100%;
            max-width: 230px;
            border-radius: 8px !important;
            border: 1.5px solid #d1d5db;
            padding: 8px 14px;
            font-size: 0.88rem;
            box-shadow: none !important;
            transition: border-color 0.2s;
        }

        .order-search-input:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1) !important;
        }

        .order-search-btn {
            border-radius: 8px !important;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 8px 16px;
        }

        .order-reset-btn {
            border-radius: 8px !important;
            font-size: 0.88rem;
            font-weight: 600;
            padding: 8px 16px;
            background: #fff;
            border: 1.5px solid #0dcaf0;
            color: #0dcaf0;
            transition: all 0.2s;
            text-decoration: none;
        }

        .order-reset-btn:hover {
            background: #0dcaf0;
            color: #fff;
        }

        /* Status filter */
        .order-status-filter {
            border-radius: 8px !important;
            font-size: 0.85rem;
            font-weight: 600;
            width: 165px;
            border: 1.5px solid #d1d5db;
            padding: 7px 12px;
            cursor: pointer;
        }

        /* Status dropdown in table */
        .status-update {
            width: 130px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 50px;
            padding: 5px 12px;
            cursor: pointer;
            outline: none !important;
            box-shadow: none !important;
            transition: all 0.2s ease;
        }

        .status-update:hover {
            opacity: 0.85;
        }

        .status-active {
            background-color: #dcfce7;
            color: #15803d;
            border: 2px solid #86efac;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 2px solid #fca5a5;
        }

        .status-pending {
            background-color: #fef9c3;
            color: #854d0e;
            border: 2px solid #fde047;
        }

        /* Action Pills */
        .action-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .action-pill i {
            font-size: 0.85rem;
        }

        .action-pill-view {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .action-pill-view:hover {
            background: #1d4ed8;
            color: #fff;
            border-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
        }

        .action-pill-pdf {
            background: #fff1f2;
            color: #be123c;
            border-color: #fecdd3;
        }

        .action-pill-pdf:hover {
            background: #be123c;
            color: #fff;
            border-color: #be123c;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(190, 18, 60, 0.25);
        }

        .action-pill-whatsapp {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .action-pill-whatsapp:hover {
            background: #15803d;
            color: #fff;
            border-color: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(21, 128, 61, 0.25);
        }

        /* Toast */
        #statusToastInner {
            border-radius: 10px;
        }

        .toast-success {
            background: #dcfce7;
            color: #15803d;
        }

        .toast-error {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* =========================================
       MOBILE RESPONSIVE FIX
    ========================================= */

        html,
        body {
            overflow-x: hidden;
        }

        .container-fluid {
            max-width: 100%;
        }

        /* Header Responsive */
        @media (max-width: 991px) {

            .container-fluid.py-4 {
                padding: 15px !important;
            }

            .row.mb-4 .d-flex.align-items-center.justify-content-between {
                flex-direction: column;
                align-items: stretch !important;
            }

            .row.mb-4 h2 {
                font-size: 24px;
            }

            .row.mb-4 p {
                font-size: 14px;
            }
        }

        /* Search & Filter Responsive */
        @media (max-width: 768px) {

            #orderFilterForm,
            #statusFilterForm {
                width: 100%;
            }

            #orderFilterForm .d-flex {
                flex-direction: column !important;
                width: 100%;
            }

            .order-search-input {
                max-width: 100%;
                width: 100%;
            }

            .order-search-btn,
            .order-reset-btn {
                width: 100%;
                justify-content: center;
            }

            .order-status-filter {
                width: 100%;
            }

            #statusFilterForm {
                flex-direction: column;
                align-items: stretch !important;
                margin-top: 10px;
            }

            #statusFilterForm label {
                margin-bottom: 5px;
            }
        }

        /* Filter Alert Responsive */
        @media (max-width: 768px) {

            .alert.d-flex.align-items-center.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
            }

            .alert .btn {
                width: 100%;
            }
        }

        /* Mobile Cards */
        @media (max-width: 768px) {

            .card-body {
                padding: 15px !important;
            }

            .card-body .fs-5 {
                font-size: 1rem !important;
                word-break: break-word;
            }

            .card-body .fs-6 {
                font-size: 0.95rem !important;
            }

            .status-update {
                width: 100% !important;
                max-width: 150px;
            }

            .card-body .d-flex.justify-content-between.align-items-center.mb-3 {
                flex-wrap: wrap;
                gap: 10px;
            }

            .card-body .small {
                word-break: break-word;
            }
        }

        /* Mobile Action Buttons */
        @media (max-width: 576px) {

            .card-body .d-flex.gap-2.pt-3 {
                flex-direction: column;
            }

            .card-body .btn {
                width: 100% !important;
                margin: 0 !important;
            }

            .action-pill-view,
            .action-pill-pdf,
            .action-pill-whatsapp {
                font-size: 14px;
            }
        }

        /* Pagination Responsive */
        @media (max-width: 576px) {

            .card-footer {
                overflow-x: auto;
            }

            .pagination {
                flex-wrap: nowrap;
            }
        }

        /* Toast Responsive */
        @media (max-width: 576px) {

            #statusToast {
                right: 10px !important;
                left: 10px !important;
                width: auto;
            }

            #statusToastInner {
                width: 100%;
            }
        }

        /* Prevent Long Text Overflow */
        .card,
        .card-body,
        .table,
        .alert,
        .order-search-input,
        .order-status-filter {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Better Mobile Card Design */
        @media (max-width: 576px) {

            .d-block.d-md-none .card {
                border-radius: 15px !important;
            }

            .d-block.d-md-none .card-body {
                padding: 14px !important;
            }

            .d-block.d-md-none .fw-bold {
                word-break: break-word;
            }
        }
    </style>

    <script>
        // Status update with AJAX + toast feedback
        document.querySelectorAll('.status-update').forEach(function (select) {
            select.addEventListener('change', function () {
                const newStatus = this.value;
                const orderId = this.dataset.id;
                const el = this;

                // Update pill color immediately
                el.className = 'form-select status-update ' +
                    (newStatus === 'completed' ? 'status-active' :
                        newStatus === 'cancelled' ? 'status-inactive' : 'status-pending');

                fetch('/admin/orders/' + orderId + '/status', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.success) {
                            showToast('✅ Status updated to "' + newStatus + '"', 'success');
                        } else {
                            showToast('❌ Failed to update status', 'error');
                        }
                    })
                    .catch(function () {
                        showToast('❌ Network error. Please try again.', 'error');
                    });
            });
        });

        function showToast(message, type) {
            const toast = document.getElementById('statusToast');
            const inner = document.getElementById('statusToastInner');
            const msgEl = document.getElementById('statusToastMsg');

            msgEl.textContent = message;
            inner.className = 'toast show align-items-center border-0 shadow toast-' + type;
            toast.style.display = 'block';

            setTimeout(function () {
                toast.style.display = 'none';
            }, 3000);
        }
    </script>
@endsection
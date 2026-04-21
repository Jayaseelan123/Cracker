@extends('layouts.admin')

@section('header', 'Enquiry Customer List')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-md-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-users me-2 text-purple"></i> Enquiry Customer List</h5>
            <div class="mt-2 mt-md-0">
                <button class="btn btn-outline-secondary btn-sm me-2" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <button class="btn btn-outline-success btn-sm">
                    <i class="fas fa-file-export me-1"></i> Export
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Section -->
            <form action="{{ route('admin.enquiry.customer') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search By Name or Mobile" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-purple w-100">Search</button>
                </div>
                @if(request('search'))
                <div class="col-md-2">
                    <a href="{{ route('admin.enquiry.customer') }}" class="btn btn-light w-100">Clear</a>
                </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>S.No</th>
                            <th>Date & Time</th>
                            <th>Customer Name</th>
                            <th>Mobile Number</th>
                            <th>Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse($orders as $index => $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $index }}</td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td class="fw-semibold">{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>
                                <span class="badge rounded-pill bg-light text-success border border-success">Active</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.view', $order->id) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                        <li><a class="dropdown-item text-success" href="https://wa.me/91{{ $order->customer_phone }}" target="_blank"><i class="fab fa-whatsapp me-2"></i> WhatsApp</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p class="h5">Sorry! No records found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .btn-purple { background-color: #6f42c1; color: white; border: none; }
    .btn-purple:hover { background-color: #59359a; color: white; }
    .text-purple { color: #6f42c1; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    @media print {
        .admin-sidebar, .sidebar, .btn, form, .pagination { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; }
    }
</style>
@endsection

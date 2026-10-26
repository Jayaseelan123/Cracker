@extends('layouts.admin')

@section('title', 'Contact Inquiries')
@section('header', 'Contact Inquiries')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Contact Form Inquiries</h2>
                <p class="text-muted mb-0">Manage visitor messages</p>
            </div>

            @if($unreadCount > 0)
                <div class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                    <i class="fas fa-envelope me-1"></i>
                    {{ $unreadCount }} Unread Messages
                </div>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search Card -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('admin.contact-inquiries.index') }}">
                    <div class="row g-3">

                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Search</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="Search by Name or Email">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied
                                </option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4 d-flex align-items-end gap-2 mt-3 mt-md-0">
                            <button class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Search
                            </button>

                            <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody id="inquiryTable">

                                @forelse($inquiries as $i => $inq)

                                    <tr class="{{ $inq->status == 'unread' ? 'table-warning' : '' }}">

                                        <td>
                                            {{ $inquiries->firstItem() + $i }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-2"
                                                    style="width:40px;height:40px;">
                                                    {{ strtoupper(substr($inq->name, 0, 1)) }}
                                                </div>

                                                <strong>{{ $inq->name }}</strong>

                                            </div>
                                        </td>

                                        <td>
                                            <a href="mailto:{{ $inq->email }}">
                                                {{ $inq->email }}
                                            </a>
                                        </td>

                                        <td>
                                            {{ Str::limit($inq->message, 60) }}
                                        </td>

                                        <td>
                                            {{ $inq->created_at->format('d M Y h:i A') }}
                                        </td>

                                        <td class="text-end">

                                            <a href="{{ route('admin.contact-inquiries.show', $inq) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <form action="{{ route('admin.contact-inquiries.destroy', $inq) }}" method="POST"
                                                class="d-inline delete-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-sm btn-danger delete-btn">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center py-5">

                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                                            <h5>No Inquiries Found</h5>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards -->
                <div class="d-block d-md-none p-3 bg-light">
                    @forelse($inquiries as $i => $inq)
                        <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body p-3">


                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"
                                        style="width:40px;height:40px;">
                                        {{ strtoupper(substr($inq->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $inq->name }}</div>
                                        <a href="mailto:{{ $inq->email }}"
                                            class="text-primary small text-decoration-none">{{ $inq->email }}</a>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small fw-bold text-uppercase mb-1">Message</div>
                                    <div class="text-dark">{{ Str::limit($inq->message, 80) }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small fw-bold text-uppercase mb-1">Date</div>
                                    <div class="fw-semibold text-dark">{{ $inq->created_at->format('d M Y h:i A') }}</div>
                                </div>

                                <div class="d-flex gap-2 pt-3 border-top mt-2">
                                    <a href="{{ route('admin.contact-inquiries.show', $inq) }}"
                                        class="btn btn-outline-primary flex-fill rounded-3 fw-bold"
                                        style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-eye me-2"></i> View
                                    </a>
                                    <form action="{{ route('admin.contact-inquiries.destroy', $inq) }}" method="POST"
                                        class="flex-fill d-flex m-0 delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger w-100 rounded-3 delete-btn fw-bold"
                                            style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25"></i>
                            <h5>No Inquiries Found</h5>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($inquiries->hasPages())
                <div class="card-footer bg-white">
                    {{ $inquiries->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>

    </div>
    <style>
        /* ========================================
                               CONTACT INQUIRIES MOBILE RESPONSIVE
                            ======================================== */

        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        .container-fluid {
            max-width: 100%;
        }

        /* Header */
        @media (max-width: 768px) {

            .container-fluid.py-4 {
                padding: 15px !important;
            }

            h2.fw-bold {
                font-size: 24px;
            }

            .badge.bg-danger.fs-6 {
                width: 100%;
                text-align: center;
                font-size: 14px !important;
            }
        }

        /* Search Card */
        @media (max-width: 768px) {

            .card-body form .row {
                row-gap: 15px;
            }

            .form-label {
                font-size: 14px;
            }

            .form-control,
            .form-select {
                font-size: 14px;
                height: 45px;
            }

            .col-12.col-md-4.d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .col-12.col-md-4.d-flex .btn {
                width: 100%;
            }
        }

        /* Desktop Table */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table td,
        .table th {
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Mobile Cards */
        @media (max-width: 768px) {

            .d-block.d-md-none {
                padding: 12px !important;
            }

            .d-block.d-md-none .card {
                border-radius: 16px !important;
                overflow: hidden;
            }

            .d-block.d-md-none .card-body {
                padding: 15px !important;
            }

            .d-block.d-md-none .fw-bold,
            .d-block.d-md-none .text-dark,
            .d-block.d-md-none .small {
                word-break: break-word;
                overflow-wrap: break-word;
            }

            .d-block.d-md-none .rounded-circle {
                min-width: 40px;
                min-height: 40px;
            }

            .d-block.d-md-none a {
                word-break: break-all;
            }
        }

        /* Mobile Buttons */
        @media (max-width: 576px) {

            .d-block.d-md-none .d-flex.gap-2.pt-3 {
                flex-direction: column;
            }

            .d-block.d-md-none .btn {
                width: 100% !important;
                margin: 0 !important;
            }

            .d-block.d-md-none .btn i {
                margin-right: 6px;
            }
        }

        /* Pagination */
        @media (max-width: 576px) {

            .card-footer {
                overflow-x: auto;
            }

            .pagination {
                flex-wrap: nowrap;
                justify-content: flex-start !important;
            }
        }

        /* Alert Responsive */
        @media (max-width: 576px) {

            .alert {
                font-size: 14px;
                padding: 12px;
            }

            .alert .btn-close {
                padding: 12px;
            }
        }

        /* Empty State */
        @media (max-width: 576px) {

            .text-center.py-5 h5 {
                font-size: 18px;
            }

            .text-center.py-5 i {
                font-size: 40px !important;
            }
        }

        /* Prevent Overflow */
        .card,
        .card-body,
        .table,
        .badge,
        .btn,
        .form-control,
        .form-select,
        .alert {
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        /* Extra Small Devices */
        @media (max-width: 375px) {

            h2.fw-bold {
                font-size: 20px;
            }

            .d-block.d-md-none .card-body {
                padding: 12px !important;
            }

            .d-block.d-md-none .fw-bold.fs-6 {
                font-size: 15px !important;
            }

            .badge {
                font-size: 11px !important;
            }

            .btn {
                font-size: 13px;
            }
        }
    </style>
@endsection

@section('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            // Delete Confirmation
            document.querySelectorAll('.delete-btn').forEach(button => {

                button.addEventListener('click', function () {

                    if (confirm('Are you sure you want to delete this inquiry?')) {

                        this.closest('form').submit();

                    }

                });

            });

            // Auto Refresh Every 30 Seconds
            setInterval(function () {

                window.location.reload();

            }, 30000);

        });

    </script>

@endsection
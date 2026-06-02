@extends('layouts.admin')

@section('title', 'Contact Inquiries')
@section('header', 'Contact Inquiries')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Contact Form Inquiries</h2>
            <p class="text-muted mb-0">Messages submitted by visitors via the contact page</p>
        </div>
        @if($unreadCount > 0)
        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
            <i class="fas fa-envelope me-1"></i> {{ $unreadCount }} Unread
        </span>
        @endif
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter Bar --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body py-3 px-4">
            <form method="GET" action="{{ route('admin.contact-inquiries.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold small text-uppercase">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control border-start-0 bg-light"
                               placeholder="Name or email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small text-uppercase">Status</label>
                    <select name="status" class="form-select bg-light">
                        <option value="">All</option>
                        <option value="unread"  {{ request('status') === 'unread'  ? 'selected' : '' }}>Unread</option>
                        <option value="read"    {{ request('status') === 'read'    ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-light border px-3">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th class="ps-4 py-3 text-muted fw-semibold small">#</th>
                            <th class="py-3 text-muted fw-semibold small">NAME</th>
                            <th class="py-3 text-muted fw-semibold small">EMAIL</th>
                            <th class="py-3 text-muted fw-semibold small">MESSAGE</th>
                            <th class="py-3 text-muted fw-semibold small">STATUS</th>
                            <th class="py-3 text-muted fw-semibold small">RECEIVED</th>
                            <th class="py-3 text-muted fw-semibold small pe-4 text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $i => $inq)
                        <tr class="{{ $inq->status === 'unread' ? 'table-warning' : '' }}">
                            <td class="ps-4 text-muted">{{ $inquiries->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                         style="width:36px;height:36px;font-size:14px;">
                                        {{ strtoupper(substr($inq->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold">{{ $inq->name }}</span>
                                </div>
                            </td>
                            <td><a href="mailto:{{ $inq->email }}" class="text-decoration-none text-muted">{{ $inq->email }}</a></td>
                            <td><span class="text-muted small">{{ Str::limit($inq->message, 60) }}</span></td>
                            <td>
                                @if($inq->status === 'unread')
                                    <span class="badge bg-warning text-dark rounded-pill px-3">Unread</span>
                                @elseif($inq->status === 'read')
                                    <span class="badge bg-info text-white rounded-pill px-3">Read</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-3">Replied</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $inq->created_at->format('d M Y, h:i A') }}</td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.contact-inquiries.show', $inq) }}"
                                       class="btn btn-sm btn-light border" title="View">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.contact-inquiries.destroy', $inq) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-light border delete-btn" title="Delete">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3 d-block"></i>
                                <h5 class="text-muted">No contact inquiries found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($inquiries->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $inquiries->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection

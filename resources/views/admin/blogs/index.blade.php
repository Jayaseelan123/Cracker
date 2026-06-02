@extends('layouts.admin')

@section('title', 'Manage Blog Posts')
@section('header', 'Blog Posts')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Blog Posts</h2>
                    <p class="text-muted mb-0">Manage your website's blog content</p>
                </div>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('admin.blogs.index') }}" class="d-flex align-items-center me-2">
                        <input type="text" name="search" class="form-control" placeholder="Search posts..." value="{{ request('search') }}" style="width: 250px;" />
                        <button type="submit" class="btn btn-primary ms-2 px-3">Search</button>
                        @if(request('search'))
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-info ms-2 px-3" title="Reset Search">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                        @endif
                    </form>
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary shadow-sm rounded-3 px-4 ms-1">
                        <i class="fas fa-plus me-2"></i>Create New Post
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        @if($blogs->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">S.No</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">{{ $blogs->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ Str::limit($blog->title, 50) }}</div>
                            <span class="text-muted small">{{ $blog->created_at->format('M d, Y') }}</span>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $blog->category }}</span></td>
                        <td class="fw-bold">{{ $blog->views }}</td>
                        <td>
                            @if($blog->is_published)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-3">Published</span>
                            @else
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle rounded-pill px-3">Draft</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '—' }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-outline-info d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="View">
                                    <i class="fas fa-eye" style="font-size: 1.1rem;"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="Edit">
                                    <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn" style="width: 38px; height: 38px;" title="Delete">
                                        <i class="fas fa-trash" style="font-size: 1.1rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-center">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3 d-block"></i>
            <h4 class="text-dark">No Blog Posts Yet</h4>
            <p class="text-muted">Start creating engaging content for your audience</p>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mt-3 px-4">Create First Post</a>
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
</style>
@endsection

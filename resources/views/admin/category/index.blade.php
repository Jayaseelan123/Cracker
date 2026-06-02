@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Categories</h2>
                    <p class="text-muted mb-0">Manage product categories</p>
                </div>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('category.index') }}" id="categorySearchForm" class="d-flex align-items-center me-2">
                        <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}" style="width: 250px;" />
                        <button type="submit" class="btn btn-primary ms-2 px-3">Search</button>
                        <a href="{{ route('category.index') }}" id="resetCategorySearch" class="btn btn-outline-info ms-2 px-3" title="Reset Search">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </form>
                    <a href="{{ route('category.create') }}" class="btn btn-primary shadow-sm rounded-3 px-4 ms-1">
                        <i class="fas fa-plus me-2"></i>Add Category
                    </a>
                </div>
            </div>
        </div>
    </div>

<div id="categoryListContainer">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">S.No</th>
                        <th>Name</th>
                        <th>Tamil Name</th>
                        <th>Slug</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
        @foreach($categories as $category)
        <tr>
            <td class="ps-4">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
            <td class="fw-bold">{{ $category->name }}</td>
            <td>{{ $category->tamil_name }}</td>
            <td class="text-muted">{{ $category->slug }}</td>
            <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="Edit Category">
                        <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                    </a>
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                        @csrf 
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn" style="width: 38px; height: 38px;" title="Delete Category">
                            <i class="fas fa-trash-alt" style="font-size: 1.1rem;"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $categories->appends(request()->input())->links('pagination::bootstrap-5') }}
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
    /* Hide the redundant 'Showing' text inside the pagination component on the right */
    .pagination-no-text .small.text-muted {
        display: none !important;
    }
    .pagination-no-text nav > div:first-child {
        display: none !important;
    }
</style>
</div>

<script>
$(document).ready(function() {
    const containerSelector = '#categoryListContainer';

    function loadCategories(url) {
        $(containerSelector).css('opacity', '0.5');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                const newContent = $(data).find(containerSelector).html();
                $(containerSelector).html(newContent);
                $(containerSelector).css('opacity', '1');
                window.history.pushState({}, '', url);
            },
            error: function() {
                $(containerSelector).css('opacity', '1');
                console.error('Failed to load categories.');
            }
        });
    }

    $(document).on('submit', '#categorySearchForm', function(e) {
        e.preventDefault();
        const url = $(this).attr('action') + '?' + $(this).serialize();
        loadCategories(url);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url) {
            loadCategories(url);
        }
    });

    $(document).on('click', '#resetCategorySearch', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        $('#categorySearchForm input[name="search"]').val('');
        loadCategories(url);
    });
});
</script>
@endsection

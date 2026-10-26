@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Categories</h2>
                        <p class="text-muted mb-0">Manage product categories</p>
                    </div>
                    <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">
                        <form method="GET" action="{{ route('category.index') }}" id="categorySearchForm"
                            class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2 flex-grow-1">
                            <input type="text" name="search" class="form-control" placeholder="Search categories..."
                                value="{{ request('search') }}" style="min-width: 200px;" />
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-3 flex-fill">Search</button>
                                <a href="{{ route('category.index') }}" id="resetCategorySearch"
                                    class="btn btn-outline-info px-3 flex-fill d-flex align-items-center justify-content-center" title="Reset Search">
                                    <i class="fas fa-sync-alt"></i><span class="d-none d-sm-inline ms-1">Reset</span>
                                </a>
                            </div>
                        </form>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#importCategoryModal"
                            class="btn btn-success shadow-sm rounded-3 px-4 text-nowrap" title="Import">
                            <i class="fas fa-file-excel me-2"></i>
                        </a>
                        <a href="{{ route('category.export') }}"
                            class="btn btn-info shadow-sm rounded-3 px-4 text-nowrap text-white" title="Export">
                            <i class="fas fa-file-export me-2"></i>
                        </a>
                        <a href="{{ route('category.create') }}"
                            class="btn btn-primary shadow-sm rounded-3 px-4 text-nowrap">
                            <i class="fas fa-plus me-2"></i>Add Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
         @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="background: #ecfdf5; color: #065f46;">
                <i class="fas fa-check-circle me-2"></i> {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {!! session('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Import Excel Modal -->
        <div class="modal fade" id="importCategoryModal" tabindex="-1" aria-labelledby="importCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('category.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="importCategoryModalLabel">Import Categories from Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted small mb-3">Upload an Excel file (.xlsx, .xls, .csv) with columns: <strong>name</strong>, <strong>tamil_name</strong>, <strong>slug</strong>.</p>
                             <div class="mb-3">
                                    <a href="{{ asset('samples/categories-sample.xlsx') }}"
                                       download
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download me-1"></i>
                                        Download Sample Excel
                                    </a>
                                </div>
                            <div class="mb-3">
                                <label for="excel_file" class="form-label">Select Excel File</label>
                                <input class="form-control" type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls, .csv" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="categoryListContainer">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead class="bg-light">
                                    <th class="ps-4">S.No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Tamil Name</th>
                                    <th>Slug</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="ps-4">
                                            {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            @if($category->image)
                                                <img src="{{ asset('category_images/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $category->name }}</td>
                                        <td>{{ $category->tamil_name }}</td>
                                        <td class="text-muted">{{ $category->slug }}</td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3"
                                                    style="width: 38px; height: 38px;" title="Edit Category">
                                                    <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                                                </a>
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn"
                                                        style="width: 38px; height: 38px;" title="Delete Category">
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

                <!-- Mobile Cards -->
                <div class="d-block d-md-none p-3 bg-light">
                    @foreach($categories as $category)
                        <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                    <span class="text-muted fw-bold" style="font-size:0.85rem;">S.No:
                                        {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-3">
                                            @if($category->image)
                                                <img src="{{ asset('category_images/' . $category->image) }}" alt="{{ $category->name }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-image fs-4"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-muted small fw-bold text-uppercase mb-1">Name (EN)</div>
                                                <div class="fw-bold text-dark fs-6">{{ $category->name }}</div>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                    <div class="text-muted small fw-bold text-uppercase mb-1">Tamil Name</div>
                                    <div class="text-dark">{{ $category->tamil_name ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small fw-bold text-uppercase mb-1">Slug</div>
                                    <div class="text-primary small">{{ $category->slug }}</div>
                                </div>

                                <div class="d-flex gap-2 pt-3 border-top mt-2">
                                    <a href="{{ route('category.edit', $category->id) }}"
                                        class="btn btn-outline-primary flex-fill rounded-3 fw-bold"
                                        style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        class="flex-fill d-flex m-0">
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
                    @endforeach

                    @if($categories->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No categories found.</p>
                        </div>
                    @endif
                </div>
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

        .pagination-no-text nav>div:first-child {
            display: none !important;
        }
    </style>
    </div>

    <script>
        $(document).ready(function () {
            const containerSelector = '#categoryListContainer';

            function loadCategories(url) {
                $(containerSelector).css('opacity', '0.5');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        const newContent = $(data).find(containerSelector).html();
                        $(containerSelector).html(newContent);
                        $(containerSelector).css('opacity', '1');
                        window.history.pushState({}, '', url);
                    },
                    error: function () {
                        $(containerSelector).css('opacity', '1');
                        console.error('Failed to load categories.');
                    }
                });
            }

            $(document).on('submit', '#categorySearchForm', function (e) {
                e.preventDefault();
                const url = $(this).attr('action') + '?' + $(this).serialize();
                loadCategories(url);
            });

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    loadCategories(url);
                }
            });

            $(document).on('click', '#resetCategorySearch', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                $('#categorySearchForm input[name="search"]').val('');
                loadCategories(url);
            });
        });
    </script>
@endsection
@extends('layouts.admin')

@section('content')


    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Products</h2>
                        <p class="text-muted mb-0">Manage your product catalog</p>
                    </div>
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                        <form method="GET" action="{{ route('products.index') }}" id="productSearchForm"
                            class="d-flex align-items-center flex-grow-1 gap-2">
                            <input type="text" name="search" class="form-control w-100" placeholder="Search products..."
                                value="{{ request('search') }}" style="min-width: 200px;" />
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-3 flex-fill">Search</button>
                                <a href="{{ route('products.index') }}" id="resetProducts"
                                    class="btn btn-outline-info px-3 flex-fill d-flex align-items-center justify-content-center"
                                    title="Reset Search">
                                    <i class="fas fa-sync-alt"></i><span class="d-none d-sm-inline ms-1">Reset</span>
                                </a>
                            </div>
                        </form>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#importProductModal"
                            class="btn btn-success shadow-sm rounded-3 px-4 text-nowrap" title="Import">
                            <i class="fas fa-file-excel me-2"></i>
                        </a>
                        <a href="{{ route('products.export') }}"
                            class="btn btn-info shadow-sm rounded-3 px-4 text-nowrap text-white" title="Export">
                            <i class="fas fa-file-export me-2"></i>
                        </a>
                        <a href="{{ route('products.create') }}"
                            class="btn btn-primary shadow-sm rounded-3 px-4 text-nowrap">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="productListContainer">
             @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="background: #ecfdf5; color: #065f46;">
                    <i class="fas fa-check-circle me-2"></i> {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Import Excel Modal -->
            <div class="modal fade" id="importProductModal" tabindex="-1" aria-labelledby="importProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title" id="importProductModalLabel">Import Products from Excel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small mb-3">Upload an Excel file (.xlsx, .xls, .csv). Supported columns: <strong>product_id, name_en, name_ta, category, rate, discount_rate, final_price, stock, status</strong>.</p>
                                 <div class="mb-3">
                                    <a href="{{ asset('samples/products-sample.xlsx') }}"
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

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <!-- Desktop Table -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Product ID</th>
                                    <th>Name (EN)</th>
                                    <th>Name (TA)</th>
                                    <th>Rate</th>
                                    <th>Discount</th>
                                    <th>Final Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge"
                                                style="background:#e8f4fd;color:#0a4f68;font-size:0.8rem;font-weight:700;letter-spacing:0.5px;padding:4px 10px;border-radius:50px;border:1px solid #bee3f8;">
                                                {{ $product->product_id ?? 'CKR-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td>{{ $product->name_en ?? $product->name ?? '—' }}</td>
                                        <td>{{ $product->name_ta ?? '—' }}</td>
                                        @php
                                            $displayRate = $product->rate ?? $product->price ?? $product->mrp ?? null;
                                            $displayDiscount = $product->discount_rate ?? 0;
                                            $displayFinal = $product->final_price ?? $product->price ?? $displayRate ?? 0;
                                        @endphp
                                        <td>₹{{ $displayRate !== null ? number_format($displayRate, 2) : '—' }}</td>
                                        <td>₹{{ number_format($displayDiscount, 2) }}</td>
                                        <td>₹{{ $displayFinal ? number_format($displayFinal, 2) : '—' }}</td>
                                        <td>
                                            @if($product->stock <= 0)
                                                <span class="badge bg-danger">0 (Out of Stock)</span>
                                            @elseif($product->stock < 10)
                                                <span class="badge bg-warning text-dark">{{ $product->stock }} (Low Stock)</span>
                                            @else
                                                <span class="badge bg-info text-dark">{{ $product->stock }}</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($product->category)->name ?? '—' }}</td>
                                        <td>
                                            <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST"
                                                class="status-form" onsubmit="event.preventDefault(); updateStatus(this);">
                                                @csrf
                                                <select name="status" onchange="this.form.dispatchEvent(new Event('submit'))"
                                                    class="status-select {{ ($product->status ?? 'Active') === 'Active' ? 'status-active' : 'status-inactive' }}">
                                                    <option value="Active" {{ ($product->status ?? 'Active') === 'Active' ? 'selected' : '' }}>● Active</option>
                                                    <option value="Inactive" {{ ($product->status ?? 'Active') === 'Inactive' ? 'selected' : '' }}>● Inactive</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            @php $img = $product->image_path ?? $product->image ?? null; @endphp
                                            @if($img)
                                                <img src="{{ asset('product_images/' . $img) }}" width="50"
                                                    alt="{{ $product->name_en ?? $product->name ?? '' }}">
                                            @else
                                                <img src="https://placehold.co/150x150/e2e8f0/64748b?text=No\nImage" width="50" class="rounded" alt="Default Image">
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3"
                                                    style="width: 38px; height: 38px;" title="Edit Product">
                                                    <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn"
                                                        style="width: 38px; height: 38px;" title="Delete Product">
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
                    @foreach($products as $product)
                        <div class="card shadow-sm border-0 rounded-4 mb-3" style="border: 1px solid #e2e8f0 !important;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                    <span class="badge"
                                        style="background:#e8f4fd;color:#0a4f68;font-size:0.8rem;font-weight:700;letter-spacing:0.5px;padding:4px 10px;border-radius:50px;border:1px solid #bee3f8;">
                                        {{ $product->product_id ?? 'CKR-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">0 (Out of Stock)</span>
                                    @elseif($product->stock < 10)
                                        <span class="badge bg-warning text-dark">{{ $product->stock }} (Low Stock)</span>
                                    @else
                                        <span class="badge bg-info text-dark">{{ $product->stock }} In Stock</span>
                                    @endif
                                </div>

                                <div class="d-flex align-items-start gap-3 mb-3">
                                    @php $img = $product->image_path ?? $product->image ?? null; @endphp
                                    @if($img)
                                        <img src="{{ asset('product_images/' . $img) }}" width="60" height="60"
                                            class="rounded-3 object-fit-cover" alt="Image">
                                    @else
                                        <img src="https://placehold.co/150x150/e2e8f0/64748b?text=No\nImage" width="60" height="60"
                                            class="rounded-3 object-fit-cover" alt="Default Image">
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark fs-6" style="line-height: 1.2;">
                                            {{ $product->name_en ?? $product->name ?? '—' }}</div>
                                        <div class="text-muted small mt-1">{{ $product->name_ta ?? '—' }}</div>
                                        <div class="text-primary small mt-1 fw-semibold">
                                            {{ optional($product->category)->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>

                                @php
                                    $displayRate = $product->rate ?? $product->price ?? $product->mrp ?? null;
                                    $displayDiscount = $product->discount_rate ?? 0;
                                    $displayFinal = $product->final_price ?? $product->price ?? $displayRate ?? 0;
                                @endphp

                                <div class="row g-2 mb-3 bg-light rounded-3 p-2 text-center mx-0">
                                    <div class="col-4 border-end">
                                        <div class="text-muted"
                                            style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Rate</div>
                                        <div class="fw-semibold text-dark" style="font-size: 0.85rem;">
                                            ₹{{ $displayRate !== null ? number_format($displayRate, 2) : '—' }}</div>
                                    </div>
                                    <div class="col-4 border-end">
                                        <div class="text-muted"
                                            style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Discount
                                        </div>
                                        <div class="fw-semibold text-danger" style="font-size: 0.85rem;">
                                            ₹{{ number_format($displayDiscount, 2) }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted"
                                            style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">Final</div>
                                        <div class="fw-bold text-success" style="font-size: 0.85rem;">
                                            ₹{{ $displayFinal ? number_format($displayFinal, 2) : '—' }}</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-muted"
                                        style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Status</div>
                                    <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST"
                                        class="status-form m-0" onsubmit="event.preventDefault(); updateStatus(this);">
                                        @csrf
                                        <select name="status" onchange="this.form.dispatchEvent(new Event('submit'))"
                                            class="status-select {{ ($product->status ?? 'Active') === 'Active' ? 'status-active' : 'status-inactive' }}"
                                            style="width:100px;">
                                            <option value="Active" {{ ($product->status ?? 'Active') === 'Active' ? 'selected' : '' }}>● Active</option>
                                            <option value="Inactive" {{ ($product->status ?? 'Active') === 'Inactive' ? 'selected' : '' }}>● Inactive</option>
                                        </select>
                                    </form>
                                </div>

                                <div class="d-flex gap-2 pt-3 border-top mt-2">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-outline-primary flex-fill rounded-3 fw-bold"
                                        style="height: 44px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
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

                    @if($products->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No products found.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->appends(request()->input())->links('pagination::bootstrap-5') }}
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

            .status-form {
                margin: 0;
            }

            .status-select {
                display: inline-block;
                width: 115px;
                padding: 5px 10px;
                font-size: 0.78rem;
                font-weight: 700;
                border-radius: 50px;
                cursor: pointer;
                outline: none !important;
                box-shadow: none !important;
                appearance: auto;
                -webkit-appearance: auto;
                transition: opacity 0.15s ease;
            }

            .status-select:hover {
                opacity: 0.82;
            }

            .status-active {
                background-color: #dcfce7;
                color: #15803d;
                border: 2px solid #86efac;
            }

            .status-inactive {
                background-color: #fee2e2;
                color: #b91c1c;
                border-color: #fca5a5;
            }
        </style>


        <script>
            function updateStatus(form) {
                let select = form.querySelector('select[name="status"]');

                // Update colors immediately for good UI experience
                if (select.value === 'Active') {
                    select.classList.remove('status-inactive');
                    select.classList.add('status-active');
                } else {
                    select.classList.remove('status-active');
                    select.classList.add('status-inactive');
                }

                // Submit via AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    // Silent update
                }).catch(error => {
                    console.error('Error updating status:', error);
                });
            }

            // AJAX Pagination and Search
            $(document).ready(function () {
                const containerSelector = '#productListContainer';
                const resetBtn = $('#resetProducts');
                const refreshIcon = resetBtn.find('i');

                function loadProducts(url) {
                    $(containerSelector).css('opacity', '0.5');
                    refreshIcon.addClass('fa-spin'); // Start spinning
                    resetBtn.addClass('disabled');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (data) {
                            const newContent = $(data).find(containerSelector).html();
                            $(containerSelector).html(newContent);
                            $(containerSelector).css('opacity', '1');
                            refreshIcon.removeClass('fa-spin'); // Stop spinning
                            resetBtn.removeClass('disabled');
                            window.history.pushState({}, '', url);

                            // Auto-hide alerts after 3 seconds if they exist
                            setTimeout(() => {
                                $('.alert').fadeOut('slow');
                            }, 3000);
                        },
                        error: function () {
                            $(containerSelector).css('opacity', '1');
                            refreshIcon.removeClass('fa-spin');
                            resetBtn.removeClass('disabled');
                            console.error('Failed to load products.');
                        }
                    });
                }

                $(document).on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    loadProducts($(this).attr('href'));
                });

                $(document).on('submit', '#productSearchForm', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('action') + '?' + $(this).serialize();
                    loadProducts(url);
                });

                $(document).on('click', '#resetProducts', function (e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    $('#productSearchForm input[name="search"]').val('');
                    loadProducts(url);
                });

                // Initial alert timeout
                setTimeout(() => {
                    $('.alert').fadeOut('slow');
                }, 3000);
            });
        </script>

@endsection
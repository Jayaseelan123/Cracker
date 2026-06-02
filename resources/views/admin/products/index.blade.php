@extends('layouts.admin')

@section('content')


<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Products</h2>
                    <p class="text-muted mb-0">Manage your product catalog</p>
                </div>
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('products.index') }}" id="productSearchForm" class="d-flex align-items-center me-2">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}" style="width: 250px;" />
                        <button type="submit" class="btn btn-primary ms-2 px-3">Search</button>
                        <a href="{{ route('products.index') }}" id="resetProducts" class="btn btn-outline-info ms-2 px-3" title="Reset Search">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </form>
                    <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm rounded-3 px-4 ms-1">
                        <i class="fas fa-plus me-2"></i>Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

<div id="productListContainer">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 custom-table">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">S.No</th>
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
            <td class="ps-4">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
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
                <form action="{{ route('products.toggleStatus', $product->id) }}" method="POST" class="status-form" onsubmit="event.preventDefault(); updateStatus(this);">
                    @csrf
                    <select name="status" onchange="this.form.dispatchEvent(new Event('submit'))"
                        class="status-select {{ ($product->status ?? 'Active') === 'Active' ? 'status-active' : 'status-inactive' }}">
                        <option value="Active"   {{ ($product->status ?? 'Active') === 'Active'   ? 'selected' : '' }}>● Active</option>
                        <option value="Inactive" {{ ($product->status ?? 'Active') === 'Inactive' ? 'selected' : '' }}>● Inactive</option>
                    </select>
                </form>
            </td>
            <td>
                @php $img = $product->image_path ?? $product->image ?? null; @endphp
                @if($img)
                    <img src="{{ asset('product_images/'.$img) }}" width="50" alt="{{ $product->name_en ?? $product->name ?? '' }}">
                @else
                    —
                @endif
            </td>
            <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center rounded-3" style="width: 38px; height: 38px;" title="Edit Product">
                        <i class="fas fa-edit" style="font-size: 1.1rem;"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-3 delete-btn" style="width: 38px; height: 38px;" title="Delete Product">
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
    .status-form { margin: 0; }

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
    .status-select:hover { opacity: 0.82; }

    .status-active { background-color: #dcfce7; color: #15803d; border: 2px solid #86efac; }
    .status-inactive { background-color: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
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
$(document).ready(function() {
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
            success: function(data) {
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
            error: function() {
                $(containerSelector).css('opacity', '1');
                refreshIcon.removeClass('fa-spin');
                resetBtn.removeClass('disabled');
                console.error('Failed to load products.');
            }
        });
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        loadProducts($(this).attr('href'));
    });

    $(document).on('submit', '#productSearchForm', function(e) {
        e.preventDefault();
        const url = $(this).attr('action') + '?' + $(this).serialize();
        loadProducts(url);
    });

    $(document).on('click', '#resetProducts', function(e) {
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

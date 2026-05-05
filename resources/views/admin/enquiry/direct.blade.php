@extends('layouts.admin')

@section('header', 'New Direct Enquiry')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Create Direct Enquiry</h2>
                    <p class="text-muted mb-0">Generate a new bill for walk-in or manual customers</p>
                </div>
                <div class="d-md-flex gap-2 d-none">
                    <div class="text-end">
                        <div class="text-muted small">Current Date</div>
                        <div class="fw-bold text-dark">{{ date('d M, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.direct.enquiry.store') }}" method="POST" id="directOrderForm">
        @csrf
        <div class="row g-4">
            <!-- Left Pane: Customer & Billing Config -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-user-circle me-2"></i>Customer Info</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Select Existing Customer</label>
                            <select name="customer_id" id="customerSelect" class="form-select form-select-lg border-light-subtle bg-light bg-opacity-50">
                                <option value="">-- New Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_phone }}" 
                                            data-name="{{ $customer->customer_name }}"
                                            data-address="{{ $customer->customer_address }}">
                                        {{ $customer->customer_name }} ({{ $customer->customer_phone }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Search and select to auto-fill details</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg border-light-subtle" placeholder="Full Name">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Full Address <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control border-light-subtle" rows="3" placeholder="Shipping Address" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted text-uppercase">Order Date</label>
                                    <input type="date" name="order_date" class="form-control border-light-subtle" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 2rem; z-index: 10;">
                    <div class="card-header bg-primary py-3 px-4 text-white">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-calculator me-2"></i>Bill Summary</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-bold text-dark" id="subTotalDisplay">₹0.00</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Packing Charges (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-light-subtle">₹</span>
                                <input type="number" name="packing_charges" id="packingCharges" class="form-control border-light-subtle" value="0">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Additional Discount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-light-subtle text-danger">-</span>
                                <input type="number" name="extra_discount" id="extraDiscount" class="form-control border-light-subtle" value="0">
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Round Off:</span>
                                <span id="roundOffDisplay" class="text-dark">₹0.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 fw-bold text-dark">Total Amount</h4>
                                <h4 class="mb-0 fw-bold text-primary" id="overallTotalDisplay">₹0.00</h4>
                            </div>
                        </div>

                        <input type="hidden" name="final_amount" id="finalAmountInput">
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-3 shadow-sm hover-up">
                            <i class="fas fa-check-circle me-2"></i>FINALIZE ENQUIRY
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Pane: Product Selection & Cart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-4 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-cart-plus me-2 text-primary"></i>Add Products to Bill</h5>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-25">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Select Product</label>
                                <select id="productSelect" class="form-select form-select-lg border-light-subtle rounded-3">
                                    <option value="">-- Start typing to search products --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-name="{{ $product->name }}"
                                                data-rate="{{ $product->rate ?? $product->price }}"
                                                data-actual="{{ $product->mrp ?? $product->price }}">
                                            {{ $product->name }} (₹{{ $product->rate ?? $product->price }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-6">
                                <label class="form-label fw-bold small text-muted">Price (₹)</label>
                                <input type="number" id="currentRate" class="form-control form-control-lg border-light-subtle" placeholder="0.00">
                            </div>
                            <div class="col-md-2 col-6">
                                <label class="form-label fw-bold small text-muted">Quantity</label>
                                <input type="number" id="currentQty" class="form-control form-control-lg border-light-subtle" value="1" min="1">
                            </div>
                            <div class="col-md-2 d-none d-md-block">
                                <label class="form-label fw-bold small text-muted">Item Total</label>
                                <input type="text" id="currentAmount" class="form-control form-control-lg bg-white border-light-subtle" readonly placeholder="0.00">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" id="addItemBtn" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="itemsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">#</th>
                                    <th>Product Details</th>
                                    <th class="text-center">Actual (MRP)</th>
                                    <th class="text-center">Sale Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-end pe-4">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="emptyRow">
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-basket fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">Your item list is currently empty.</p>
                                            <small>Search and add products from the panel above.</small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="itemRowTemplate">
    <tr class="item-row animate-in">
        <td class="ps-4 sNo text-muted">1</td>
        <td>
            <div class="fw-bold text-dark itemName">Product Name</div>
        </td>
        <td class="text-center text-muted small itemActual">₹0.00</td>
        <td class="text-center fw-semibold itemRate">₹0.00</td>
        <td class="text-center">
            <span class="badge bg-soft-info text-info rounded-pill px-3 py-2 itemQty">1</span>
        </td>
        <td class="text-center fw-bold text-dark itemTotal">₹0.00</td>
        <td class="text-end pe-4">
            <button type="button" class="btn btn-icon btn-light-danger remove-item">
                <i class="fas fa-trash-alt"></i>
            </button>
            <input type="hidden" class="in-id">
            <input type="hidden" class="in-qty">
            <input type="hidden" class="in-rate">
        </td>
    </tr>
</template>

<style>
    :root {
        --primary-color: #4f46e5;
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --secondary-bg: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background-color: #f4f7fe;
        color: #334155;
    }

    .card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05) !important;
    }

    .bg-primary {
        background: var(--primary-gradient) !important;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .btn-primary {
        background: var(--primary-gradient);
        border: none;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .form-control, .form-select {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #818cf8;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        background: #f8fafc;
        border-top: none;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .bg-soft-info {
        background-color: #e0f2fe;
    }
    
    .text-info {
        color: #0284c7 !important;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-light-danger {
        background-color: #fee2e2;
        color: #ef4444;
        border: none;
    }
    
    .btn-light-danger:hover {
        background-color: #ef4444;
        color: white;
        transform: scale(1.05);
    }

    .animate-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hover-up:hover {
        transform: translateY(-2px);
    }
</style>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Searchable Dropdowns
    $('#productSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search for a product...'
    });
    
    $('#customerSelect').select2({
        theme: 'bootstrap-5'
    });

    const productSelect = $('#productSelect');
    const customerSelect = $('#customerSelect');
    const currentRate = document.getElementById('currentRate');
    const currentQty = document.getElementById('currentQty');
    const currentAmount = document.getElementById('currentAmount');
    const addItemBtn = document.getElementById('addItemBtn');
    const itemsTableBody = document.querySelector('#itemsTable tbody');
    const emptyRow = document.getElementById('emptyRow');
    const subTotalDisplay = document.getElementById('subTotalDisplay');
    const packingCharges = document.getElementById('packingCharges');
    const extraDiscount = document.getElementById('extraDiscount');
    const roundOffDisplay = document.getElementById('roundOffDisplay');
    const overallTotalDisplay = document.getElementById('overallTotalDisplay');
    const finalAmountInput = document.getElementById('finalAmountInput');
    const itemRowTemplate = document.getElementById('itemRowTemplate');

    let items = [];

    // Customer Selection Logic
    customerSelect.on('change', function() {
        const val = this.value;
        if(val) {
            const opt = this.options[this.selectedIndex];
            document.getElementById('customer_name').value = opt.dataset.name;
            document.getElementById('address').value = opt.dataset.address;
        } else {
            document.getElementById('customer_name').value = '';
            document.getElementById('address').value = '';
        }
    });

    // Product Selection & Pricing
    productSelect.on('change', function() {
        const val = this.value;
        if(val) {
            const opt = this.options[this.selectedIndex];
            currentRate.value = opt.dataset.rate;
            updateCurrentAmount();
        }
    });

    [currentRate, currentQty].forEach(el => {
        el.addEventListener('input', updateCurrentAmount);
    });

    function updateCurrentAmount() {
        const rate = parseFloat(currentRate.value) || 0;
        const qty = parseInt(currentQty.value) || 0;
        currentAmount.value = (rate * qty).toFixed(2);
    }

    // Add Item to List
    addItemBtn.addEventListener('click', function() {
        const val = productSelect.val();
        if(!val) return alert('Please select a product first');
        
        const opt = productSelect[0].options[productSelect[0].selectedIndex];
        const item = {
            id: val,
            name: opt.dataset.name,
            actual: parseFloat(opt.dataset.actual),
            rate: parseFloat(currentRate.value),
            qty: parseInt(currentQty.value)
        };

        if(item.qty <= 0) return alert('Quantity must be at least 1');

        items.push(item);
        renderTable();
        resetInput();
    });

    function resetInput() {
        productSelect.val('').trigger('change');
        currentRate.value = '';
        currentQty.value = 1;
        currentAmount.value = '';
    }

    function renderTable() {
        itemsTableBody.innerHTML = '';
        if(items.length === 0) {
            itemsTableBody.appendChild(emptyRow);
            updateTotals();
            return;
        }

        items.forEach((item, index) => {
            const clone = itemRowTemplate.content.cloneNode(true);
            clone.querySelector('.sNo').textContent = index + 1;
            clone.querySelector('.itemName').textContent = item.name;
            clone.querySelector('.itemActual').textContent = '₹' + item.actual.toFixed(2);
            clone.querySelector('.itemRate').textContent = '₹' + item.rate.toFixed(2);
            clone.querySelector('.itemQty').textContent = item.qty;
            clone.querySelector('.itemTotal').textContent = '₹' + (item.rate * item.qty).toFixed(2);
            
            clone.querySelector('.in-id').value = item.id;
            clone.querySelector('.in-id').name = `items[${index}][product_id]`;
            clone.querySelector('.in-qty').value = item.qty;
            clone.querySelector('.in-qty').name = `items[${index}][quantity]`;
            clone.querySelector('.in-rate').value = item.rate;
            clone.querySelector('.in-rate').name = `items[${index}][price]`;

            clone.querySelector('.remove-item').addEventListener('click', () => {
                items.splice(index, 1);
                renderTable();
            });

            itemsTableBody.appendChild(clone);
        });

        updateTotals();
    }

    function updateTotals() {
        const subtotal = items.reduce((sum, item) => sum + (item.rate * item.qty), 0);
        const packing = parseFloat(packingCharges.value) || 0;
        const discount = parseFloat(extraDiscount.value) || 0;
        
        const total = subtotal + packing - discount;
        const roundedTotal = Math.round(total);
        const roundOff = roundedTotal - total;

        subTotalDisplay.textContent = '₹' + subtotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        roundOffDisplay.textContent = '₹' + roundOff.toLocaleString('en-IN', {minimumFractionDigits: 2});
        overallTotalDisplay.textContent = '₹' + roundedTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        finalAmountInput.value = roundedTotal;
    }

    [packingCharges, extraDiscount].forEach(el => {
        el.addEventListener('input', updateTotals);
    });
});
</script>
@endpush
@endsection


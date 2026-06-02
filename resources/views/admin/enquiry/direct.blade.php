@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Premium Select2 Styling */
    .select2-container--default .select2-selection--single {
        height: 60px !important;
        border-radius: 18px !important;
        border: 1px solid #dee2e6 !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 15px !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 58px !important;
        right: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-weight: 700 !important;
        color: #0d6efd !important;
        font-size: 1rem !important;
    }
    .select2-dropdown {
        border-radius: 15px !important;
        border: 1px solid #dee2e6 !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        overflow: hidden !important;
        margin-top: 5px !important;
        background-color: #fff !important;
    }
    .select2-results__options {
        max-height: 350px !important; /* Premium Scrollable Area */
    }
    /* Sleek Scrollbar */
    .select2-results__options::-webkit-scrollbar {
        width: 6px;
    }
    .select2-results__options::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .select2-search__field {
        border-radius: 10px !important;
        padding: 10px 15px !important;
        border: 1px solid #e2e8f0 !important;
    }
    .select2-results__option {
        padding: 12px 15px !important;
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        border-bottom: 1px solid #f1f5f9;
    }
    .select2-results__option--highlighted {
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>
@endpush

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
                            <label class="form-label fw-semibold small text-muted text-uppercase">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg border-light-subtle" placeholder="Full Name" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone" id="customer_phone" class="form-control form-control-lg border-light-subtle" placeholder="Phone Number" required>
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

            </div>

            <!-- Right Pane: Product Selection & Cart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-4 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-cart-plus me-2 text-primary"></i>Add Products to Bill</h5>
                    </div>
                    <div class="card-body p-4 bg-light bg-opacity-25">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">SELECT PRODUCT</label>
                                <select id="productSelect" class="form-select product-select2 border-light-subtle rounded-4 shadow-sm">
                                    <option value="">Search for a produ...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-name="{{ $product->name }}"
                                                data-rate="{{ $product->rate ?? $product->price }}"
                                                data-actual="{{ $product->mrp ?? $product->price }}"
                                                data-stock="{{ $product->stock }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="form-label fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">PRICE (₹)</label>
                                <input type="number" id="currentRate" class="form-control form-control-lg text-center fw-bold text-primary border-light-subtle" placeholder="0.00" style="border-radius: 18px; height: 60px; background: #f8f9fa;">
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="form-label fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">QTY</label>
                                <input type="number" id="currentQty" class="form-control form-control-lg text-center fw-bold border-light-subtle" value="1" min="1" style="border-radius: 18px; height: 60px; color: #333;">
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="form-label fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">STOCK</label>
                                <input type="text" id="availableStock" class="form-control form-control-lg bg-light text-center border-0" readonly placeholder="0" style="border-radius: 18px; height: 60px; color: #666;">
                            </div>
                            <div class="col-md-3 text-center">
                                <label class="form-label fw-bold text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">TOTAL</label>
                                <input type="text" id="currentAmount" class="form-control form-control-lg bg-white border-light-subtle text-center fw-bold text-dark" readonly placeholder="0.00" style="border-radius: 18px; height: 60px;">
                            </div>
                        </div>

                    </div>
                    
                    <div class="card-body p-4 bg-light border-top border-bottom">
                        <div class="row align-items-center">
                            <!-- Left: Additional Charges -->
                            <div class="col-md-6 border-end pe-md-4">
                                <h6 class="fw-bold mb-4 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Billing Adjustments</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-muted text-uppercase">Packing Charges (₹)</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-muted fw-bold">₹</span>
                                        <input type="number" name="packing_charges" id="packingCharges" class="form-control border-start-0 ps-0 fw-medium" value="0">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold small text-muted text-uppercase">Additional Discount (₹)</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-danger fw-bold">-</span>
                                        <input type="number" name="extra_discount" id="extraDiscount" class="form-control border-start-0 ps-0 text-danger fw-bold" value="0">
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="button" id="addItemBtn" class="btn btn-success btn-lg w-100 py-3 rounded-3 shadow-sm fw-bold fs-5 text-white" style="background: #10b981; border: none; height: 60px;">
                                        <i class="fas fa-plus me-2"></i> ADD PRODUCT TO BILL
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Right: Total Summary -->
                            <div class="col-md-6 ps-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted fw-medium">Subtotal</span>
                                        <span class="fw-bold text-dark fs-5" id="subTotalDisplay">₹0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                        <span class="text-muted fw-medium">Round Off</span>
                                        <span id="roundOffDisplay" class="text-muted fw-medium">₹0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 1px;">Grand Total</span>
                                        <h2 class="mb-0 fw-black text-primary" id="overallTotalDisplay" style="font-weight: 800;">₹0.00</h2>
                                    </div>
                                    
                                    <input type="hidden" name="final_amount" id="finalAmountInput">
                                    
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-3 shadow hover-up d-flex justify-content-center align-items-center gap-2">
                                        <i class="fas fa-check-circle fs-5"></i>
                                        <span>FINALIZE ENQUIRY</span>
                                    </button>
                                </div>
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
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Stock</th>
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
    </form>
</div>

<template id="itemRowTemplate">
    <tr class="item-row animate-in">
        <td class="ps-4 sNo text-muted fw-medium">1</td>
        <td>
            <div class="fw-bold text-dark itemName" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Product Name</div>
        </td>
        <td class="text-center text-muted small itemActual">₹0.00</td>
        <td class="text-center" style="width: 100px;">
            <input type="number" class="form-control form-control-lg text-center itemQtyInput fw-bold text-primary border-light-subtle shadow-sm" style="border-radius: 12px; background: #fff; padding-left: 0; padding-right: 0;" min="1">
        </td>
        <td class="text-center">
            <span class="badge itemAvailability">Available</span>
        </td>
        <td class="text-center fw-bold text-dark itemTotal fs-6">₹0.00</td>
        <td class="text-end pe-4">
            <button type="button" class="btn btn-icon btn-light-danger remove-item">
                <i class="fas fa-trash-alt"></i>
            </button>
            <input type="hidden" class="in-id">
            <input type="hidden" class="in-qty">
            <input type="hidden" class="in-rate itemRateInput">
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

    .itemQtyInput {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .itemQtyInput:focus {
        transform: scale(1.05);
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4) !important;
    }

    /* Hide arrows from number input */
    .itemQtyInput::-webkit-inner-spin-button,
    .itemQtyInput::-webkit-outer-spin-button,
    #currentQty::-webkit-inner-spin-button,
    #currentQty::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .itemQtyInput, #currentQty {
        -moz-appearance: textfield;
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Searchable Dropdowns
    $('#productSelect').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search for a product...',
        width: '100%'
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
            document.getElementById('customer_phone').value = val;
            document.getElementById('address').value = opt.dataset.address;
        } else {
            document.getElementById('customer_name').value = '';
            document.getElementById('customer_phone').value = '';
            document.getElementById('address').value = '';
        }
    });

    // Product Selection & Pricing
    productSelect.on('change', function() {
        const val = $(this).val();
        const availableStockInput = document.getElementById('availableStock');
        if(val) {
            const opt = $(this).find('option:selected');
            $('#currentRate').val(opt.data('rate'));
            
            const stock = parseInt(opt.data('stock')) || 0;
            availableStockInput.value = stock;
            if(stock > 0) {
                availableStockInput.className = 'form-control form-control-lg fw-bold text-center text-success bg-success bg-opacity-10';
            } else {
                availableStockInput.className = 'form-control form-control-lg fw-bold text-center text-danger bg-danger bg-opacity-10';
            }
        } else {
            $('#currentRate').val('');
            availableStockInput.value = '0';
            availableStockInput.className = 'form-control form-control-lg bg-light fw-bold text-center';
        }
        updateCurrentAmount();
    });

    $('#currentRate, #currentQty').on('input change keyup', function() {
        updateCurrentAmount();
    });

    function updateCurrentAmount() {
        const rateText = $('#currentRate').val();
        const qtyText = $('#currentQty').val();
        const rate = parseFloat(rateText) || 0;
        const qty = parseInt(qtyText) || 0;
        $('#currentAmount').val((rate * qty).toFixed(2));
    }

    // Add Item to List
    addItemBtn.addEventListener('click', function() {
        const val = productSelect.val();
        if(!val) {
            return Swal.fire({ icon: 'warning', title: 'Product Required', text: 'Please select a product first.', confirmButtonColor: '#10b981' });
        }
        
        const qty = parseInt(currentQty.value) || 0;
        const rate = parseFloat(currentRate.value) || 0;
        const stock = parseInt(document.getElementById('availableStock').value) || 0;
        
        if(qty <= 0) {
            return Swal.fire({ icon: 'warning', title: 'Invalid Quantity', text: 'Quantity must be at least 1.', confirmButtonColor: '#10b981' });
        }
        
        if(qty > stock && stock > 0) {
            Swal.fire({
                title: 'Low Stock',
                text: `You are adding ${qty} units but only ${stock} are available. Continue?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it',
                confirmButtonColor: '#10b981'
            }).then((result) => {
                if (result.isConfirmed) {
                    processAddItem(val, qty, rate, stock);
                }
            });
        } else if (stock <= 0) {
            Swal.fire({
                title: 'Out of Stock',
                text: 'This product is currently out of stock. Do you still want to add it?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it anyway',
                confirmButtonColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    processAddItem(val, qty, rate, stock);
                }
            });
        } else {
            processAddItem(val, qty, rate, stock);
        }
    });

    function processAddItem(val, qty, rate, stock) {
        const existingItemIndex = items.findIndex(i => i.id === val);

        if (existingItemIndex !== -1) {
            items[existingItemIndex].qty += qty;
            items[existingItemIndex].rate = rate;
        } else {
            const opt = productSelect.find('option:selected');
            const item = {
                id: val,
                name: opt.data('name'),
                actual: parseFloat(opt.data('actual')) || rate,
                rate: rate,
                qty: qty,
                stock: stock
            };
            items.push(item);
        }

        renderTable();
        resetInput();
        
        // Success Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        Toast.fire({ icon: 'success', title: 'Item added to bill' });
    }

    // Reset Form Button
    document.getElementById('resetFormBtn').addEventListener('click', function() {
        if(items.length > 0) {
            Swal.fire({
                title: 'Clear Bill?',
                text: 'This will remove all items from the current bill.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, clear it',
                confirmButtonColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    items = [];
                    renderTable();
                    resetInput();
                }
            });
        } else {
            resetInput();
        }
    });

    // Form Submit Validation & Enter Key Handling
    document.getElementById('directOrderForm').addEventListener('submit', function(e) {
        if(items.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Empty Bill',
                text: 'Please add at least one product to the bill before finalizing.',
                confirmButtonColor: '#4f46e5'
            });
        }
    });

    // Prevent 'Enter' key from submitting the whole form prematurely, instead trigger Add Item
    document.getElementById('directOrderForm').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            if (e.target.id === 'currentQty' || e.target.id === 'currentRate' || e.target.tagName === 'SELECT') {
                addItemBtn.click();
            }
        }
    });

    function resetInput() {
        productSelect.val('').trigger('change');
        currentRate.value = '';
        currentQty.value = 1;
        currentAmount.value = '';
        document.getElementById('availableStock').value = '0';
        document.getElementById('availableStock').className = 'form-control form-control-lg bg-light fw-bold text-center';
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
            
            const rateInput = clone.querySelector('.itemRateInput');
            rateInput.value = item.rate;
            // No listener needed for visible rate input as it is removed

            const qtyInput = clone.querySelector('.itemQtyInput');
            qtyInput.value = item.qty;
            
            const updateAvailability = (inputVal, stockVal, badge) => {
                if (stockVal >= inputVal) {
                    badge.textContent = stockVal;
                    badge.className = 'badge bg-success';
                    badge.title = 'Available';
                } else {
                    badge.textContent = stockVal;
                    badge.className = 'badge bg-danger';
                    badge.title = 'Insufficient Stock';
                }
            };
            
            const availabilityBadge = clone.querySelector('.itemAvailability');
            updateAvailability(item.qty, item.stock, availabilityBadge);

            qtyInput.addEventListener('input', function() {
                const newQty = parseInt(this.value) || 0;
                items[index].qty = newQty;
                clone.querySelector('.itemTotal').textContent = '₹' + (items[index].rate * newQty).toFixed(2);
                clone.querySelector('.in-qty').value = newQty;
                updateAvailability(newQty, items[index].stock, availabilityBadge);
                updateTotals();
            });

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

    $('#packingCharges, #extraDiscount').on('input change keyup', function() {
        updateTotals();
    });
});
</script>
@endpush
@endsection


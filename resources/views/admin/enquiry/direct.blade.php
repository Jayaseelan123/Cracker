@extends('layouts.admin')

@section('header', 'Direct Enquiry')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.direct.enquiry.store') }}" method="POST" id="directOrderForm">
        @csrf
        <div class="row">
            <!-- Left Side: Order & Customer Details -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-file-invoice me-2 text-purple"></i> Order Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small uppercase fw-bold">Order Date</label>
                            <input type="date" name="order_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small uppercase fw-bold">Select Customer</label>
                            <select name="customer_id" id="customerSelect" class="form-select">
                                <option value="">-- New Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_phone }}" 
                                            data-name="{{ $customer->customer_name }}"
                                            data-address="{{ $customer->customer_address }}">
                                        {{ $customer->customer_name }} ({{ $customer->customer_phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small uppercase fw-bold">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small uppercase fw-bold">Address (*)</label>
                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter Address" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small uppercase fw-bold">Staff</label>
                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                            <input type="hidden" name="staff_id" value="{{ auth()->id() }}">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Sub Total:</span>
                            <span class="fw-bold" id="subTotalDisplay">₹0.00</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Packing Charges</label>
                            <input type="number" name="packing_charges" id="packingCharges" class="form-control form-control-sm" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Extra Discount</label>
                            <input type="number" name="extra_discount" id="extraDiscount" class="form-control form-control-sm" value="0">
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Round OFF:</span>
                            <span id="roundOffDisplay">₹0.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold text-purple">Overall Total:</h4>
                            <h4 class="mb-0 fw-bold text-purple" id="overallTotalDisplay">₹0.00</h4>
                        </div>
                        <input type="hidden" name="final_amount" id="finalAmountInput">
                        
                        <button type="submit" class="btn btn-purple w-100 mt-4 py-2 fw-bold shadow-sm">
                            <i class="fas fa-check-circle me-2"></i> COMPLETE BILL
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Product Selection & Items Table -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-search-plus me-2 text-purple"></i> Add Products</h5>
                    </div>
                    <div class="card-body bg-light-subtle">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold">Select Product</label>
                                <select id="productSelect" class="form-select">
                                    <option value="">-- Choose Product --</option>
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
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Rate (*)</label>
                                <input type="number" id="currentRate" class="form-control" placeholder="0.00">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Qty (*)</label>
                                <input type="number" id="currentQty" class="form-control" value="1" min="1">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Amount</label>
                                <input type="text" id="currentAmount" class="form-control bg-light" readonly placeholder="0.00">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" id="addItemBtn" class="btn btn-purple w-100">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-0 table-responsive">
                        <table class="table table-hover mb-0 align-middle" id="itemsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">S.No</th>
                                    <th>Product Name</th>
                                    <th>Actual Price</th>
                                    <th>Final Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items will be added here -->
                                <tr id="emptyRow">
                                    <td colspan="7" class="text-center py-5 text-muted small">
                                        No products added yet. Start by selecting a product above.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-3 align-items-center">
                    <span class="fs-5 text-muted">Bill Total :</span>
                    <span class="fs-3 fw-bold text-dark" id="billTotalDisplay">₹0.00</span>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="itemRowTemplate">
    <tr>
        <td class="ps-3 sNo">1</td>
        <td class="itemName">Product Name</td>
        <td class="itemActual text-muted">₹0.00</td>
        <td class="itemRate">₹0.00</td>
        <td class="itemQty">1</td>
        <td class="itemTotal fw-bold">₹0.00</td>
        <td class="text-end pe-3">
            <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-item">
                <i class="fas fa-trash"></i>
            </button>
            <input type="hidden" name="items[INDEX][product_id]" class="in-id">
            <input type="hidden" name="items[INDEX][qty]" class="in-qty">
            <input type="hidden" name="items[INDEX][rate]" class="in-rate">
        </td>
    </tr>
</template>

<style>
    .btn-purple { background-color: #6f42c1; color: white; border: none; }
    .btn-purple:hover { background-color: #59359a; color: white; }
    .text-purple { color: #6f42c1; }
    .bg-light-subtle { background-color: #f8f9fa; }
    .form-label.uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .card { overflow: hidden; }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('productSelect');
    const currentRate = document.getElementById('currentRate');
    const currentQty = document.getElementById('currentQty');
    const currentAmount = document.getElementById('currentAmount');
    const addItemBtn = document.getElementById('addItemBtn');
    const itemsTableBody = document.querySelector('#itemsTable tbody');
    const emptyRow = document.getElementById('emptyRow');
    const subTotalDisplay = document.getElementById('subTotalDisplay');
    const billTotalDisplay = document.getElementById('billTotalDisplay');
    const packingCharges = document.getElementById('packingCharges');
    const extraDiscount = document.getElementById('extraDiscount');
    const roundOffDisplay = document.getElementById('roundOffDisplay');
    const overallTotalDisplay = document.getElementById('overallTotalDisplay');
    const finalAmountInput = document.getElementById('finalAmountInput');
    const customerSelect = document.getElementById('customerSelect');
    const itemRowTemplate = document.getElementById('itemRowTemplate');

    let items = [];

    // Customer Selection Logic
    customerSelect.addEventListener('change', function() {
        if(this.value) {
            const opt = this.options[this.selectedIndex];
            document.getElementById('customer_name').value = opt.dataset.name;
            document.getElementById('address').value = opt.dataset.address;
        } else {
            document.getElementById('customer_name').value = '';
            document.getElementById('address').value = '';
        }
    });

    // Product Selection & Pricing
    productSelect.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if(opt.value) {
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
        const opt = productSelect.options[productSelect.selectedIndex];
        if(!opt.value) return alert('Please select a product');
        
        const item = {
            id: opt.value,
            name: opt.dataset.name,
            actual: parseFloat(opt.dataset.actual),
            rate: parseFloat(currentRate.value),
            qty: parseInt(currentQty.value)
        };

        if(item.qty <= 0) return alert('Quantity must be greater than 0');

        items.push(item);
        renderTable();
        resetInput();
    });

    function resetInput() {
        productSelect.value = '';
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

        subTotalDisplay.textContent = '₹' + subtotal.toFixed(2);
        billTotalDisplay.textContent = '₹' + subtotal.toFixed(2);
        roundOffDisplay.textContent = '₹' + roundOff.toFixed(2);
        overallTotalDisplay.textContent = '₹' + roundedTotal.toFixed(2);
        finalAmountInput.value = roundedTotal;
    }

    [packingCharges, extraDiscount].forEach(el => {
        el.addEventListener('input', updateTotals);
    });
});
</script>
@endpush
@endsection

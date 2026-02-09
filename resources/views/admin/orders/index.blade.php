@extends('layouts.admin')

@section('content')
<h2>Orders</h2>

<div class="d-flex mb-3">
    <form method="GET">
        <label>Filter by Status:</label>
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option {{ request('status')=='All' ? 'selected' : '' }}>All</option>
            <option {{ request('status')=='pending' ? 'selected' : '' }}>pending</option>
            <option {{ request('status')=='processing' ? 'selected' : '' }}>processing</option>
            <option {{ request('status')=='completed' ? 'selected' : '' }}>completed</option>
            <option {{ request('status')=='cancelled' ? 'selected' : '' }}>cancelled</option>
        </select>
    </form>
</div>

<table class="table table-bordered">
<thead>
    <tr>
        <th>#</th>
        <th>Order No</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Transaction ID</th>
        <th>LLR Number</th>
        <th>Place</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($orders as $order)
    <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->order_number }}</td>
        <td>{{ $order->customer_name }}<br>{{ $order->customer_phone ?? '-' }}</td>
        <td class="text-success">₹{{ number_format($order->total_amount) }}</td>
        <td>
            <select class="form-select status-update" data-id="{{ $order->id }}">
                <option value="pending" {{ $order->status=="pending" ? 'selected':'' }}>pending</option>
                <option value="processing" {{ $order->status=="processing" ? 'selected':'' }}>processing</option>
                <option value="completed" {{ $order->status=="completed" ? 'selected':'' }}>completed</option>
                <option value="cancelled" {{ $order->status=="cancelled" ? 'selected':'' }}>cancelled</option>
            </select>
        </td>
        <td>{{ $order->transaction_id ?? '-' }}</td>
        <td>{{ $order->llr_number ?? '-' }}</td>
        <td>
    {{
        $order->place
        ?? $order->city
        ?? $order->location
        ?? $order->shipping_city
        ?? $order->shipping_address
        ?? $order->address
        ?? '-'
    }}
</td>

        <td>
            <a href="{{ route('admin.orders.view', $order->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
            <a href="{{ route('admin.orders.pdf', $order->id) }}" class="btn btn-purple"><i class="fa fa-file"></i></a>
            @if($order->customer_phone)
            <a href="https://wa.me/+91{{ $order->customer_phone }}" target="_blank" class="btn btn-success"><i class="fa fa-whatsapp"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
</table>

{{ $orders->links() }}

<script>
document.querySelectorAll('.status-update').forEach(select => {
    select.addEventListener('change', function () {
        fetch(`/admin/orders/${this.dataset.id}/status`, {
            method: "POST",
            headers:{
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({status:this.value})
        });
    });
});
</script>

@endsection
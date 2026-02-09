<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estimate Bill #{{ $order->order_number }}</title>

    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: Arial, sans-serif; color: #333; }

        .a4 { width: 100%; margin: auto; }

        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 160px; }

        .company-info {
            text-align: center;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .title { text-align: center; font-size: 20px; font-weight: 700; margin-bottom: 5px; }
        .order-id { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 5px; }

        .date { font-size: 14px; margin-bottom: 20px; }

        .two-col {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .col-box { width: 45%; }
        .col-title { font-size: 14px; font-weight: bold; margin-bottom: 8px; }

        .col-box p { margin: 3px 0; font-size: 13px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px; }

        th, td { padding: 10px; border: 1px solid #aaa; }
        th { font-weight: bold; background: #f5f5f5; }

        td:nth-child(2) { text-align: center; }
        td:nth-child(3), td:nth-child(4) { text-align: right; }

        .grand-total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="a4">

    <!-- LOGO -->
    <div class="logo">
        <img src="{{ public_path('logo.png') }}" alt="Crackers Time Logo">
    </div>

    <!-- COMPANY INFO -->
    <div class="company-info">
        Door No 2/554/C3, Southside School Near, Sivakasi to Sattur Main Road, <br>
        Mettamalai, Sivakasi, 626203<br>
        Phone: +91 9488864547, Email: crackerstime.com@gmail.com
    </div>

    <!-- TITLE -->
    <div class="title">ESTIMATE BILL</div>
    <div class="order-id">#{{ $order->order_number }}</div>

    <div class="date"><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</div>

    <!-- BILL TO + SHIP TO -->
    <div class="two-col">
        <div class="col-box">
            <div class="col-title">Bill To:</div>

            <p>{{ $order->customer_name }}</p>
            <p>{{ $order->customer_phone }}</p>
            <p>{{ $order->customer_email }}</p>
        </div>

        <div class="col-box">
            <div class="col-title">Ship To:</div>

            <p>{{ $order->customer_address }}</p>
            <p>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
            <p>{{ $order->country }}</p>
        </div>
    </div>

    <!-- ORDER ITEMS -->
    <h3 style="font-size: 15px;">Order Items</h3>

    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rs. {{ number_format($item->price, 2) }}</td>
            <td>Rs. {{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <!-- GRAND TOTAL -->
    <div class="grand-total">
        Grand Total: Rs. {{ number_format($order->total_amount, 2) }}
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for shopping with us!<br>
        This is a computer-generated estimate bill and does not require a signature.
    </div>

</div>

</body>
</html>

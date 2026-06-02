<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estimate Bill #{{ $order->order_number }}</title>

    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: Arial, sans-serif; color: #333; }

        .a4 { width: 100%; margin: auto; }

        .logo { text-align: center; margin-bottom: 8px; }
        .logo img { width: 120px; }

        .company-info {
            text-align: center;
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .title { text-align: center; font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .order-id { text-align: center; font-size: 13px; font-weight: bold; margin-bottom: 4px; }

        .date { font-size: 12px; margin-bottom: 15px; }

        .two-col {
            width: 100%;
            margin-bottom: 15px;
            border: none;
        }

        .two-col td {
            width: 50%;
            vertical-align: top;
            border: none !important;
            padding: 0 8px 0 0 !important;
        }

        .col-title { font-size: 12px; font-weight: bold; margin-bottom: 6px; border-bottom: 1px solid #ddd; padding-bottom: 3px; }

        .two-col p { margin: 3px 0; font-size: 11px; }

        table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 11px; }

        th, td { padding: 6px; border: 1px solid #aaa; }
        th { font-weight: bold; background: #f5f5f5; }

        .items-table td:nth-child(2) { text-align: center; }
        .items-table td:nth-child(3), .items-table td:nth-child(4) { text-align: right; }

        .grand-total {
            text-align: right;
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="a4">

    <!-- LOGO -->
    <div class="logo">
        @php
            $logoPath = public_path('images/logo.png');
            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
        @endphp
        @if($logoData)
            <img src="data:image/png;base64,{{ $logoData }}" alt="Crackers Time Logo">
        @else
            <h2>Crackers Time</h2>
        @endif
    </div>

    <!-- COMPANY INFO -->
    <div class="company-info">
        Door No 2/554/C3, Southside School Near, Sivakasi to Sattur Main Road, <br>
        Mettamalai, Sivakasi, 626203<br>
        Phone: +91 9488864547, Email: crackerstime.com@gmail.com
    </div>

    <!-- TITLE -->
    <div class="title">ESTIMATE BILL</div>
    <div style="text-align: center; font-size: 13px; color: #555; margin-bottom: 10px;">Order Details & Invoice Summary</div>
    <div class="order-id">#{{ $order->order_number }}</div>

    <div class="date"><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</div>

    <!-- BILL TO + SHIP TO -->
    <table class="two-col">
        <tr>
            <td>
                <div class="col-title">Bill To:</div>
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email ?? '-' }}</p>
            </td>
            <td style="padding-right: 0 !important; padding-left: 10px !important;">
                <div class="col-title">Ship To:</div>
                <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                <p><strong>Place:</strong> {{ $order->place ?? '-' }}</p>
                <p><strong>District / City:</strong> {{ $order->city }}</p>
                <p><strong>State:</strong> {{ $order->state }} @if($order->pincode)- {{ $order->pincode }}@endif</p>
                <p><strong>Country:</strong> {{ $order->country ?? 'India' }}</p>
            </td>
        </tr>
    </table>

    <!-- ORDER ITEMS -->
    <h3 style="font-size: 15px;">Order Items</h3>

    <table class="items-table">
        <thead>
        <tr>
            <th style="text-align: left;">Product</th>
            <th>Qty</th>
            <th style="text-align: right;">Price</th>
            <th style="text-align: right;">Total</th>
        </tr>
        </thead>

        <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ optional($item->product)->name ?? 'Product Deleted' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rs. {{ number_format($item->price, 2) }}</td>
            <td>Rs. {{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <!-- BILLING SUMMARY BREAKDOWN -->
    <div style="margin-top: 20px; text-align: right;">
        <table style="width: 250px; margin-left: auto; border: none; font-size: 12px; line-height: 1.6; border-collapse: collapse;">
            <tbody>
                <tr style="border: none;">
                    <td style="border: none; padding: 3px 6px; text-align: left;">Sub Total:</td>
                    <td style="border: none; padding: 3px 6px; text-align: right;">Rs. {{ number_format($order->items->sum('total'), 2) }}</td>
                </tr>
                @if(($order->packing_charges ?? 0) > 0)
                <tr style="border: none;">
                    <td style="border: none; padding: 3px 6px; text-align: left;">Packing Charges:</td>
                    <td style="border: none; padding: 3px 6px; text-align: right;">Rs. {{ number_format($order->packing_charges, 2) }}</td>
                </tr>
                @endif
                @php
                    $sub = (float) $order->items->sum('total');
                    $pack = (float) ($order->packing_charges ?? 0);
                    $total = $sub + $pack;
                    $rounded = round($total);
                    $roundOff = $rounded - $total;
                @endphp
                @if(abs($roundOff) > 0.01)
                <tr style="border: none;">
                    <td style="border: none; padding: 3px 6px; text-align: left;">Round OFF:</td>
                    <td style="border: none; padding: 3px 6px; text-align: right;">Rs. {{ number_format($roundOff, 2) }}</td>
                </tr>
                @endif
                <tr style="border: none; border-top: 1px solid #333; font-weight: bold;">
                    <td style="border: none; padding: 6px; text-align: left; font-size: 14px;">Overall Amount:</td>
                    <td style="border: none; padding: 6px; text-align: right; font-size: 14px;">Rs. {{ number_format($rounded, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for shopping with us!<br>
        This is a computer-generated estimate bill and does not require a signature.
    </div>

</div>

</body>
</html>

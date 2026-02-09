@extends('layouts.front')

@section('content')
<style>
    .success-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        padding: 20px;
    }

    .success-card {
        background: white;
        border-radius: 15px;
        padding: 50px 40px;
        max-width: 650px;
        width: 100%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .success-icon {
        text-align: center;
        margin-bottom: 30px;
        font-size: 60px;
    }

    .success-title {
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        color: #22c55e;
        margin-bottom: 10px;
    }

    .order-number-label {
        text-align: center;
        font-size: 16px;
        color: #666;
        margin-bottom: 5px;
    }

    .order-number {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color: #9333ea;
        margin-bottom: 40px;
        word-break: break-all;
    }

    .order-details-box {
        background: #f9f9f9;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .details-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
        font-size: 14px;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #333;
    }

    .detail-value {
        color: #666;
        text-align: right;
        flex: 1;
        padding-left: 20px;
    }

    .detail-value.total {
        font-size: 18px;
        font-weight: bold;
        color: #9333ea;
    }

    .info-box {
        background: #f0f4ff;
        border-left: 4px solid #3b82f6;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .info-title {
        font-weight: bold;
        color: #1e40af;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-title::before {
        content: "ℹ";
        display: inline-block;
        width: 24px;
        height: 24px;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 24px;
        font-weight: bold;
        font-size: 14px;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        color: #1e40af;
        margin-bottom: 8px;
        font-size: 14px;
        padding-left: 20px;
        position: relative;
    }

    .info-list li::before {
        content: "•";
        position: absolute;
        left: 0;
        font-weight: bold;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .btn-continue {
        flex: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .contact-link {
        text-align: center;
        font-size: 14px;
    }

    .contact-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .contact-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .success-card {
            padding: 30px 20px;
        }

        .success-title {
            font-size: 24px;
        }

        .detail-row {
            flex-direction: column;
        }

        .detail-value {
            text-align: left;
            padding-left: 0;
            margin-top: 5px;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="success-container">
    <div class="success-card">
        <!-- Success Icon -->
        <div class="success-icon">
            Happy Diwali
        </div>

        <!-- Success Title -->
        <div class="success-title">Order Placed Successfully!</div>

        <!-- Order Number -->
        <div class="order-number-label">Your Order Number:</div>
        <div class="order-number">{{ $order->order_number }}</div>

        <!-- Order Details Box -->
        <div class="order-details-box">
            <div class="details-title">Order Details</div>

            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value">{{ $order->customer_name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value">{{ $order->customer_phone }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Address:</span>
                <span class="detail-value">{{ $order->customer_address }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Total Amount:</span>
                <span class="detail-value total">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Important Information -->
        <div class="info-box">
            <div class="info-title">Important Information</div>
            <ul class="info-list">
                <li>Your order will be delivered within 2-3 working days</li>
                <li>Once payment done the order delivered to you</li>
                <li>You will receive order updates via SMS and email</li>
                <li>Contact us if you have any questions about your order</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('home') }}" class="btn-continue">Continue Shopping</a>
        </div>

        <!-- Contact Link -->
        <div class="contact-link">
            <a href="{{ route('contact') }}">Contact Us</a>
        </div>
    </div>
</div>
@endsection

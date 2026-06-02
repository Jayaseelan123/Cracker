<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products List</title>
    <style>
        @php
            $fontSize = \App\Models\SiteSetting::get('pdf_font_size', '9');
            $showDiscount = \App\Models\SiteSetting::bool('show_discount_row', true);
            $showCode = \App\Models\SiteSetting::bool('show_product_code', false);
            $priceFormat = \App\Models\SiteSetting::get('price_format', 'INR');
        @endphp
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: {{ $fontSize }}pt;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0a4f68;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #0a4f68;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .category-header {
            background-color: #0a4f68;
            color: #fff;
            padding: 8px 15px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        @if(\App\Models\SiteSetting::bool('print_show_logo', true) && $company && $company->logo)
            <img src="{{ public_path($company->logo) }}" alt="Logo" style="max-height: 50px; margin-bottom: 10px;">
        @endif
        <h1>{{ $company->company_name ?? 'CrackerTime' }}</h1>
        <p>Products Price List - {{ date('F d, Y') }}</p>
        @if($company && $company->contact_number)
            <p>Phone: {{ $company->contact_number }} 
                @if($company->whatsapp_number) | WhatsApp: {{ $company->whatsapp_number }} @endif
            </p>
        @endif
    </div>

    @foreach($categories as $category)
        @if($category->products->count() > 0)
            <div class="category-header">
                {{ $category->name }}
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="10%" class="text-center">S.No</th>
                        <th width="{{ $showDiscount ? '40%' : '65%' }}">Product Name</th>
                        @if($showDiscount)
                        <th width="25%" class="text-center">MRP ({{ $priceFormat }})</th>
                        @endif
                        <th width="25%" class="text-center">Price ({{ $priceFormat }})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $index => $product)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                @if($showCode && !empty($product->sku))
                                    <span style="font-size: 0.9em; color: #555;">[{{ $product->sku }}]</span> 
                                @endif
                                {{ $product->name_en ?? $product->name }}
                                @if(!empty($product->name_ta))
                                    <br><small style="color: #666;">{{ $product->name_ta }}</small>
                                @endif
                            </td>
                            @if($showDiscount)
                            <td class="text-center">{{ number_format($product->mrp, 2) }}</td>
                            @endif
                            <td class="text-center"><strong>{{ number_format($product->price, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach

    @if($customMsg = \App\Models\SiteSetting::get('print_custom_message'))
        <div style="margin-top: 30px; text-align: center; font-size: 0.9em; color: #555; border-top: 1px solid #ddd; padding-top: 10px;">
            {!! nl2br(e($customMsg)) !!}
        </div>
    @endif

</body>
</html>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>মানি রিসিট #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'SolaimanLipi', 'Kalpurush', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 76mm;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
        .subtitle { font-size: 11px; margin-bottom: 8px; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 3px 0; font-size: 11px; }
        .total-box { margin-top: 6px; }
        .total-row { display: flex; justify-content: space-between; padding: 2px 0; }
        .qr-placeholder {
            border: 1px solid #333;
            padding: 4px;
            display: inline-block;
            margin-top: 6px;
            font-size: 9px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="title">{{ $order->branch ? $order->branch->name : config('app.name') }}</div>
        <div class="subtitle">{{ $order->branch ? $order->branch->address : 'ঢাকা, বাংলাদেশ' }}</div>
        <div class="subtitle">ফোন: {{ $order->branch ? $order->branch->phone : '০১৭১১-০০০০০০' }}</div>
    </div>

    <div class="divider"></div>

    <div>
        <div><strong>অর্ডার নং:</strong> {{ $order->order_number }}</div>
        <div><strong>ট্র্যাকিং পিন:</strong> {{ $order->token_pin }}</div>
        <div><strong>তারিখ:</strong> {{ $order->created_at->format('d/m/Y h:i A') }}</div>
        <div><strong>গ্রাহক:</strong> {{ $order->customer->name }} ({{ $order->customer->phone }})</div>
        @if($order->trial_date)
            <div><strong>ট্রায়াল তারিখ:</strong> {{ $order->trial_date->format('d/m/Y') }}</div>
        @endif
        @if($order->delivery_date)
            <div><strong>ডেলিভারি তারিখ:</strong> <span class="bold">{{ $order->delivery_date->format('d/m/Y') }}</span></div>
        @endif
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr style="border-bottom: 1px solid #000;">
                <th style="text-align: left;">আইটেম / পোশাক</th>
                <th style="text-align: right;">পরিমাণ</th>
                <th style="text-align: right;">টাকা</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ ucfirst($item->garment_type) }}</strong><br>
                        <small style="color: #444;">{{ $item->fabric_source === 'shop_inventory' ? 'দোকানের কাপড়' : 'গ্রাহকের কাপড়' }}</small>
                    </td>
                    <td style="text-align: right;">১</td>
                    <td style="text-align: right;">৳{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table style="width: 100%;">
        <tr>
            <td>মোট মূল্য:</td>
            <td style="text-align: right;">৳{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount_amount > 0)
        <tr>
            <td>ডিসকাউন্ট:</td>
            <td style="text-align: right;">- ৳{{ number_format($order->discount_amount, 2) }}</td>
        </tr>
        @endif
        <tr class="bold">
            <td>সর্বমোট:</td>
            <td style="text-align: right;">৳{{ number_format($order->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td>জমা / অগ্রিম:</td>
            <td style="text-align: right;">৳{{ number_format($order->advance_amount, 2) }}</td>
        </tr>
        <tr class="bold" style="font-size: 13px;">
            <td>অবশিষ্ট বকেয়া:</td>
            <td style="text-align: right; color: #b91c1c;">৳{{ number_format($order->due_amount, 2) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center">
        <div>পেমেন্ট মোড: <strong>{{ strtoupper($order->payment_method) }}</strong></div>
        <div class="qr-placeholder">
            [ QR: {{ url('/track-order?phone='.$order->customer->phone.'&pin='.$order->token_pin) }} ]
        </div>
        <div style="font-size: 10px; margin-top: 6px;">অনলাইনে অর্ডার ট্র্যাক করতে কিউআর কোড স্ক্যান করুন</div>
        <div style="font-size: 10px; margin-top: 4px;">ধন্যবাদ! আবার আসবেন।</div>
    </div>
</body>
</html>

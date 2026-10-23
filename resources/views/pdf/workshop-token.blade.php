<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>ওয়ার্কশপ কাটিং ও সেলাই স্লিপ #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'SolaimanLipi', 'Kalpurush', sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #000;
            padding: 15px;
        }
        .header { border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px; }
        .grid { display: table; width: 100%; }
        .col { display: table-cell; vertical-align: top; }
        .box { border: 1px solid #333; padding: 10px; margin-bottom: 12px; background: #fafafa; }
        .measure-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .measure-table th, .measure-table td {
            border: 1px solid #666;
            padding: 6px;
            text-align: center;
            font-size: 13px;
        }
        .measure-table th { background: #eee; }
        .bold { font-weight: bold; }
        .tag { background: #000; color: #fff; padding: 2px 6px; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div style="float: right; text-align: right;">
            <span class="tag">ওয়ার্কশপ কপি</span>
            <div style="font-size: 18px; font-weight: bold; margin-top: 4px;">{{ $order->order_number }}</div>
            <div>ডেলিভারি তারিখ: <strong>{{ $order->delivery_date ? $order->delivery_date->format('d/m/Y') : 'জরুরি' }}</strong></div>
        </div>
        <div>
            <h2 style="margin: 0;">{{ $order->branch ? $order->branch->name : config('app.name') }}</h2>
            <div>কারিগর ও মাস্টার কাটিং স্লিপ</div>
            <div>গ্রাহক: <strong>{{ $order->customer->name }}</strong> (মোবাইল: {{ $order->customer->phone }})</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    @foreach($order->items as $index => $item)
        <div class="box">
            <div style="font-size: 15px; font-weight: bold; border-bottom: 1px dashed #666; padding-bottom: 4px;">
                পোশাক #{{ $index + 1 }}: {{ strtoupper($item->garment_type) }} 
                ({{ $item->fabric_source === 'shop_inventory' ? 'দোকানের কাপড় - '.$item->fabric_yards_used.' গজ' : 'গ্রাহকের দেওয়া নিজস্ব কাপড়' }})
            </div>

            <!-- Body Measurements Grid -->
            @if(!empty($item->custom_measurements))
                <div style="margin-top: 8px;">
                    <strong>পরিমাপের বিবরণ (ইঞ্চিতে):</strong>
                    <table class="measure-table">
                        <thead>
                            <tr>
                                @foreach($item->custom_measurements as $key => $val)
                                    <th>{{ ucfirst($key) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($item->custom_measurements as $key => $val)
                                    <td class="bold" style="font-size: 14px; color: #000;">{{ $val }}"</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Custom Styles -->
            @if(!empty($item->style_attributes))
                <div style="margin-top: 8px; font-size: 12px;">
                    <strong>ডিজাইন ও স্টাইল স্পেসিফিকেশন:</strong>
                    <ul style="margin: 4px 0 0 16px; padding: 0;">
                        @foreach($item->style_attributes as $styleKey => $styleVal)
                            <li><strong>{{ ucfirst(str_replace('_', ' ', $styleKey)) }}:</strong> {{ $styleVal }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($item->special_instructions)
                <div style="margin-top: 6px; padding: 6px; background: #fffae6; border: 1px solid #ffd166; font-size: 12px;">
                    <strong>বিশেষ নির্দেশনা:</strong> {{ $item->special_instructions }}
                </div>
            @endif
        </div>
    @endforeach

    <div style="margin-top: 20px; font-size: 11px; text-align: center; border-top: 1px dashed #aaa; padding-top: 8px;">
        দর্জি প্রো অটোমেটেড ওয়ার্কশপ স্লিপ | প্রিন্ট সময়: {{ now()->format('d M Y, h:i A') }}
    </div>
</body>
</html>

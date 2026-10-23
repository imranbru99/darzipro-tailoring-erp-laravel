@extends('layouts.public')

@section('title', 'অর্ডার ট্র্যাকিং - দর্জি প্রো')

@section('content')
<div class="py-12 bg-slate-50 min-h-[75vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-8">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-widest">লাইভ ট্র্যাকিং</span>
            <h1 class="text-3xl font-black text-slate-900 mt-1">আপনার টেইলারিং অর্ডারের অগ্রগতি জানুন</h1>
            <p class="text-slate-500 text-sm mt-2">রিসিটে দেওয়া মোবাইল নম্বর ও ৪ সংখ্যার টোকেন পিন প্রবেশ করান।</p>
        </div>

        <!-- Search Box -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
            <form action="{{ route('order.track') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">গ্রাহকের মোবাইল নম্বর</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        value="{{ request('phone') }}" 
                        placeholder="যেমন: 01711223344" 
                        required 
                        class="w-full text-sm rounded-xl border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    />
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">টোকেন পিন (PIN)</label>
                    <input 
                        type="text" 
                        name="pin" 
                        value="{{ request('pin') }}" 
                        placeholder="যেমন: 8421" 
                        required 
                        class="w-full text-sm rounded-xl border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    />
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        অর্ডার খুঁজুন
                    </button>
                </div>
            </form>
        </div>

        @if($searched)
            @if($order)
                <!-- Order Result Box -->
                <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
                    
                    <!-- Header -->
                    <div class="bg-slate-900 text-white p-6 flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <span class="text-xs uppercase font-bold text-emerald-400">অর্ডার নম্বর</span>
                            <h2 class="text-2xl font-black">{{ $order->order_number }}</h2>
                            <div class="text-xs text-slate-300 mt-1">শাখা: {{ $order->branch ? $order->branch->name : 'প্রধান শাখা' }}</div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ in_array($order->order_status, ['ready_for_delivery', 'delivered']) ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-slate-900' }}">
                                @switch($order->order_status)
                                    @case('confirmed') নিশ্চিতকৃত @break
                                    @case('in_cutting') কাটিং মাস্টার কাজ করছেন @break
                                    @case('in_sewing') কারিগর সেলাই করছেন @break
                                    @case('finishing') আয়রন ও ফিনিশিং চলছে @break
                                    @case('ready_for_delivery') ডেলিভারির জন্য প্রস্তুত @break
                                    @case('delivered') ডেলিভারি সম্পন্ন @break
                                    @default {{ $order->order_status }}
                                @endswitch
                            </span>
                            <div class="text-xs text-slate-400 mt-2">ডেলিভারি তারিখ: <strong>{{ $order->delivery_date ? $order->delivery_date->format('d M Y') : 'শীঘ্রই' }}</strong></div>
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-4">অর্ডার প্রগ্রেস ধাপ:</span>
                        
                        @php
                            $steps = [
                                'confirmed'          => 'অর্ডার নিশ্চিত',
                                'in_cutting'         => 'কাটিং মাস্টার',
                                'in_sewing'          => 'সেলাই কারিগর',
                                'finishing'          => 'আয়রন ফিনিশিং',
                                'ready_for_delivery' => 'ডেলিভারি প্রস্তুত',
                                'delivered'          => 'ডেলিভার্ড',
                            ];
                            $keys = array_keys($steps);
                            $currentIndex = array_search($order->order_status, $keys);
                            if ($currentIndex === false) $currentIndex = 0;
                        @endphp

                        <div class="grid grid-cols-2 sm:grid-cols-6 gap-2 text-center text-xs">
                            @foreach($steps as $k => $stepLabel)
                                @php
                                    $stepIdx = array_search($k, $keys);
                                    $isPassed = $stepIdx <= $currentIndex;
                                @endphp
                                <div class="p-2.5 rounded-xl border {{ $isPassed ? 'bg-emerald-50 border-emerald-300 text-emerald-800 font-bold' : 'bg-white border-slate-200 text-slate-400' }}">
                                    <div class="text-base mb-1">{{ $isPassed ? '✓' : '○' }}</div>
                                    <div>{{ $stepLabel }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Financial Summary & Garments -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-3">পোশাক তালিকা (Items)</h3>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                                        <div class="font-bold text-slate-800 text-sm">{{ ucfirst($item->garment_type) }}</div>
                                        <div class="text-slate-500 mt-1">
                                            কাপড়: {{ $item->fabric_source === 'shop_inventory' ? 'দোকানের কাপড়' : 'গ্রাহকের দেওয়া কাপড়' }}
                                        </div>
                                        @if(!empty($item->style_attributes))
                                            <div class="mt-2 text-slate-600">
                                                @foreach($item->style_attributes as $stK => $stV)
                                                    <span class="inline-block bg-white px-2 py-0.5 rounded border border-slate-200 mr-1 mb-1">{{ $stV }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-3">বিলিং ও পেমেন্ট বিবরণ</h3>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2 text-sm">
                                <div class="flex justify-between text-slate-600">
                                    <span>মোট বিল:</span>
                                    <span>৳{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-emerald-600 font-semibold">
                                    <span>ইতিমধ্যে পরিশোধ:</span>
                                    <span>৳{{ number_format($order->advance_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-rose-600 font-black text-base border-t border-slate-200 pt-2">
                                    <span>অবশিষ্ট বকেয়া:</span>
                                    <span>৳{{ number_format($order->due_amount, 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <a 
                                    href="{{ route('order.thermal-receipt', $order) }}" 
                                    target="_blank"
                                    class="flex-1 text-center py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-1.5"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    মানি রিসিট ডাউনলোড (PDF)
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-6 rounded-2xl text-center">
                    <div class="text-2xl mb-1">⚠️</div>
                    <h3 class="font-bold text-base">কোনো অর্ডার পাওয়া যায়নি!</h3>
                    <p class="text-xs text-rose-600 mt-1">অনুগ্রহ করে রিসিটের মোবাইল নম্বর এবং ৪ সংখ্যার পিন সঠিক কিনা তা নিশ্চিত করুন।</p>
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

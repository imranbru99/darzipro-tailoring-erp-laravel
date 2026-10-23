@extends('layouts.public')

@section('title', 'গজ কাপড় ও ফ্যাশন ক্যাটালগ - দর্জি প্রো')

@section('content')
<div class="py-12 bg-slate-50 min-h-[75vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-emerald-600 font-bold text-xs uppercase tracking-widest">অনলাইন কালেকশন</span>
                <h1 class="text-3xl font-black text-slate-900 mt-1">গজ কাপড় ও পোশাক ক্যাটালগ</h1>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                <a href="{{ route('catalog.index') }}" class="px-3 py-2 rounded-lg {{ !request('type') ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    সব কালেকশন
                </a>
                <a href="{{ route('catalog.index', ['type' => 'fabric']) }}" class="px-3 py-2 rounded-lg {{ request('type') === 'fabric' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    গজ কাপড় (Fabrics)
                </a>
                <a href="{{ route('catalog.index', ['type' => 'readymade']) }}" class="px-3 py-2 rounded-lg {{ request('type') === 'readymade' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    তৈরি পোশাক (Readymade)
                </a>
                <a href="{{ route('catalog.index', ['type' => 'accessory']) }}" class="px-3 py-2 rounded-lg {{ request('type') === 'accessory' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                    এক্সেসরিজ ও আতর
                </a>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-100 rounded-xl flex items-center justify-center text-4xl mb-4 border border-slate-100">
                            @if($product->product_type === 'fabric')
                                🧵
                            @elseif($product->product_type === 'readymade')
                                👔
                            @else
                                🧴
                            @endif
                        </div>
                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-700 rounded text-[11px] font-bold">
                            {{ ucfirst($product->product_type) }}
                        </span>
                        <h3 class="font-bold text-slate-900 text-base mt-2">{{ $product->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description ?: 'উন্নত মানের ফেব্রিক ও নিখুঁত ফিনিশিং।' }}</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-slate-400">মূল্য (প্রতি {{ $product->unit }}):</span>
                            <div class="text-lg font-black text-emerald-600">৳{{ number_format($product->selling_price, 2) }}</div>
                        </div>
                        <a href="{{ route('order.track') }}" class="text-xs font-bold text-white bg-slate-900 hover:bg-emerald-600 px-3 py-2 rounded-lg transition">
                            অর্ডার করুন
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16 bg-white rounded-2xl border border-slate-200">
                    <p class="text-slate-400 text-sm">এই ক্যাটাগরিতে বর্তমানে কোনো পণ্য নেই।</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>
</div>
@endsection

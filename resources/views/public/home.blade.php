@extends('layouts.public')

@section('title', 'দর্জি প্রো - সর্বাধুনিক টেইলারিং ইআরপি ও ফ্যাশন ক্যাটালগ')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-bold uppercase tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    সম্পূর্ণ বাংলাদেশী দর্জি ব্যবসার জন্য তৈরি অল-ইন-ওয়ান সিস্টেম
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                    ডিজিটাল হোক আপনার <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">দর্জি ব্যবসা ও বুটিক</span>
                </h1>

                <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-xl">
                    পাঞ্জাবি, পায়জামা, শার্ট, প্যান্ট, বোরকা ও কামিজের সঠিক বডি মাপ সংরক্ষণ, কারিগর পিস-রেট মজুরি, থার্মাল পিওএস রিসিট, বায়োমেট্রিক হাজিরা মেশিন ও মাল্টি-শাখা পরিচালনা—সবকিছু এখন এক সফটওয়্যারে।
                </p>

                <!-- Search Tracking Quick Form -->
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 max-w-xl shadow-2xl">
                    <form action="{{ route('order.track') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <input 
                            type="tel" 
                            name="phone" 
                            placeholder="আপনার মোবাইল নম্বর লিখুন..." 
                            required 
                            class="flex-1 bg-white/90 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                        <input 
                            type="text" 
                            name="pin" 
                            placeholder="টোকেন পিন (যেমন: 8421)" 
                            required 
                            class="w-full sm:w-44 bg-white/90 text-slate-900 px-4 py-3 rounded-xl text-sm font-medium placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                        />
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black px-6 py-3 rounded-xl text-sm transition shadow-lg flex items-center justify-center gap-1.5 whitespace-nowrap">
                            ট্র্যাক করুন
                        </button>
                    </form>
                    <div class="text-[11px] text-slate-400 mt-2">গ্রাহকগণ কোনো লগইন ছাড়াই তাদের ডেলিভারি অগ্রগতি দেখতে পারেন।</div>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="/admin/login" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-6 py-3 rounded-xl text-sm shadow-md transition flex items-center gap-2">
                        <span>সরাসরি ডেমো টেস্ট করুন (ERP Login)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#features" class="border border-slate-700 hover:border-slate-500 text-slate-300 font-semibold px-6 py-3 rounded-xl text-sm transition">
                        ফিচার গাইড
                    </a>
                </div>
            </div>

            <!-- Right Hero Card: Demo Credentials & Live Preview -->
            <div class="lg:col-span-5">
                <div class="bg-slate-900/90 backdrop-blur-xl border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <div>
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">রেডিমেড টেস্ট একাউন্টস</span>
                            <h3 class="text-xl font-bold text-white mt-0.5">১-ক্লিক ডেমো ইউজার এক্সেস</h3>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-950 border border-emerald-500/30 text-emerald-300 text-xs font-bold rounded-lg">
                            পাসওয়ার্ড: password123
                        </span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="p-3 bg-slate-950/70 rounded-xl border border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-white">সুপার এডমিন (Super Admin)</span>
                                <div class="text-slate-400">admin@darzipro.test</div>
                            </div>
                            <span class="px-2 py-0.5 bg-purple-900/40 text-purple-300 border border-purple-500/30 rounded font-medium">অল-এক্সেস</span>
                        </div>

                        <div class="p-3 bg-slate-950/70 rounded-xl border border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-white">ধানমন্ডি ব্রাঞ্চ ম্যানেজার</span>
                                <div class="text-slate-400">manager.dhanmondi@darzipro.test</div>
                            </div>
                            <span class="px-2 py-0.5 bg-blue-900/40 text-blue-300 border border-blue-500/30 rounded font-medium">ব্রাঞ্চ কন্ট্রোল</span>
                        </div>

                        <div class="p-3 bg-slate-950/70 rounded-xl border border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-white">কাটিং মাস্টার (Master Cutter)</span>
                                <div class="text-slate-400">cutter@darzipro.test</div>
                            </div>
                            <span class="px-2 py-0.5 bg-amber-900/40 text-amber-300 border border-amber-500/30 rounded font-medium">কাটিং স্লিপ</span>
                        </div>

                        <div class="p-3 bg-slate-950/70 rounded-xl border border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-white">সেলাই কারিগর (Sewing Artisan)</span>
                                <div class="text-slate-400">karigar@darzipro.test</div>
                            </div>
                            <span class="px-2 py-0.5 bg-teal-900/40 text-teal-300 border border-teal-500/30 rounded font-medium">পিস-রেট মজুরি</span>
                        </div>

                        <div class="p-3 bg-slate-950/70 rounded-xl border border-slate-800/80 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-white">কাউন্টার পিওএস ক্যাশিয়ার</span>
                                <div class="text-slate-400">cashier@darzipro.test</div>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-900/40 text-emerald-300 border border-emerald-500/30 rounded font-medium">ক্যাশ ও থার্মাল রিসিট</span>
                        </div>
                    </div>

                    <a href="/admin/login" class="block w-full text-center bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black py-3 rounded-xl transition shadow-lg">
                        এখনই লগইন প্যানেলে যান &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features Grid -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-extrabold text-xs uppercase tracking-widest">মডুলার ফিচারস</span>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-2">
                একটি টেইলারিং ব্যবসার প্রয়োজনীয় সবকিছু
            </h2>
            <p class="text-slate-500 text-sm mt-3">
                দোকানের প্রয়োজন অনুযায়ী যেকোনো মডিউল চালু বা বন্ধ রাখার স্বাধীনতা রয়েছে।
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 1. Measurement Vault -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    📐
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">বডি মাপ ভল্ট</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    পাঞ্জাবি, শার্ট, প্যান্ট, কামিজ ও সালোয়ারের নিখুঁত মাপ (ইঞ্চি ও সুতা ভগ্নাংশ) সংরক্ষণ করুন। পুরোনো মাপ ১-ক্লিকে লোড হবে।
                </p>
            </div>

            <!-- 2. Artisan Wage -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    🧵
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">কারিগর মজুরি ট্র্যাকিং</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    কাটিং মাস্টার ও সেলাই কারিগরদের পিস-প্রতি মজুরি (যেমন: প্যান্ট ২৫০৳, পাঞ্জাবি ২০০৳), অগ্রিম টাকা ও সাপ্তাহিক লেজার ব্যবস্থাপনা।
                </p>
            </div>

            <!-- 3. Unicode Bangla POS -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    🧾
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">বাংলা থার্মাল রিসিট</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    <code class="text-emerald-700">laravel-unicode-pdf</code> দিয়ে স্পষ্ট বাংলা ফন্টে গ্রাহক ইনভয়েস ও ওয়ার্কশপ কাটিং টোকেন প্রিন্ট করুন।
                </p>
            </div>

            <!-- 4. Multi-Branch Isolation -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    🏢
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">মাল্টি-শাখা ইআরপি</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    ধানমন্ডি, উত্তরা, চট্টগ্রামের মতো বহু শাখার জন্য আলাদা ইনভেন্টরি, ক্যাশ কাউন্টার ও কেন্দ্রীয় হেড অফিস ড্যাশবোর্ড।
                </p>
            </div>

            <!-- 5. Biometric Attendance -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    ⏱️
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">বায়োমেট্রিক হাজিরা</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    <code class="text-emerald-700">laravel-attendance-hub</code> দিয়ে ZKTeco বা ফিঙ্গারপ্রিন্ট ডিভাইসের সাথে স্বয়ংক্রিয় স্টাফ ও কারিগর হাজিরা সিঙ্ক।
                </p>
            </div>

            <!-- 6. AI Fashion Hub -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    🤖
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">এআই স্টাইল কনসালটেন্ট</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    <code class="text-emerald-700">laravel-ai-hub</code> এর মাধ্যমে শরীরের উচ্চতা ও বডি শেইপ অনুযায়ী কলার, কাট এবং গজ কাপড় নির্ধারণ।
                </p>
            </div>

            <!-- 7. Fast Counter POS -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    ⚡
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">কাউন্টার ক্যাশিয়ার পিওএস</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    ডেলিভারির সময় বকেয়া টাকা আদায়, নগদ/বিকাশ/নগদ পেমেন্ট এন্ট্রি এবং রেডিমেড আতর, টুপি, গজ কাপড় বিক্রয়।
                </p>
            </div>

            <!-- 8. Speed Optimization -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:shadow-xl transition group">
                <div class="w-12 h-12 rounded-xl bg-lime-100 text-lime-700 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                    🚀
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">দ্রুতগতি পারফরম্যান্স</h3>
                <p class="text-slate-600 text-xs leading-relaxed">
                    <code class="text-emerald-700">drutogoti</code> পারফরম্যান্স ইঞ্জিন দিয়ে ডেটাবেজ কুয়েরি মনিটরিং ও অপ্টিমাইজেশন।
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Fabric Store -->
<section class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-emerald-600 font-extrabold text-xs uppercase tracking-widest">ফেব্রিক স্টোর</span>
                <h2 class="text-3xl font-black text-slate-900 mt-1">গজ কাপড় ও প্রিমিয়াম কালেকশন</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-emerald-700 hover:text-emerald-800 font-bold text-sm flex items-center gap-1 mt-4 md:mt-0">
                সম্পূর্ণ ক্যাটালগ দেখুন &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredFabrics as $fabric)
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="h-40 bg-slate-100 rounded-xl flex items-center justify-center text-4xl mb-4 border border-slate-100">
                        🧵
                    </div>
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[11px] font-bold">গজ কাপড়</span>
                    <h3 class="font-bold text-slate-900 text-base mt-2">{{ $fabric->name }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ $fabric->fabric_composition ?: '১০০% ফাইন কটন' }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400">প্রতি গজ:</span>
                            <div class="text-lg font-black text-emerald-600">৳{{ number_format($fabric->selling_price, 2) }}</div>
                        </div>
                        <a href="{{ route('order.track') }}" class="text-xs font-bold text-slate-700 bg-slate-100 hover:bg-emerald-600 hover:text-white px-3 py-2 rounded-lg transition">
                            অর্ডার করুন
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-slate-400 text-sm">
                    কোনো ফেব্রিক পণ্য পাওয়া যায়নি। সিডার রান করার পর স্বয়ংক্রিয়ভাবে প্রদর্শিত হবে।
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Branches Section -->
<section id="branches" class="py-20 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-emerald-600 font-extrabold text-xs uppercase tracking-widest">লোকেশন</span>
            <h2 class="text-3xl font-black text-slate-900 mt-1">আমাদের শাখা নেটওয়ার্ক</h2>
            <p class="text-slate-500 text-sm mt-2">আপনার নিকটবর্তী শাখায় এসে মাপ প্রদান করুন ও ট্রায়াল নিন।</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($branches as $branch)
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="px-2.5 py-1 bg-slate-900 text-white rounded text-xs font-bold">{{ $branch->code }}</span>
                    <h3 class="font-bold text-slate-900 text-lg mt-3">{{ $branch->name }}</h3>
                    <div class="text-xs text-emerald-600 font-semibold mb-3">{{ $branch->bangla_name }}</div>
                    <div class="space-y-2 text-xs text-slate-600">
                        <div>📍 {{ $branch->address }}</div>
                        <div>📞 {{ $branch->phone }}</div>
                        <div>⏰ প্রতিদিন সকাল ১০:০০ - রাত ৯:০০</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

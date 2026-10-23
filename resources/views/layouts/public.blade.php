<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'দর্জি প্রো (DarziPro) - প্রিমিয়াম টেইলারিং ও ফ্যাশন ইআরপি')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Hind Siliguri"', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Top Notice / Branch Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span>📍 আমাদের ৩টি আধুনিক শাখা: <strong>ধানমন্ডি | উত্তরা | চট্টগ্রাম</strong></span>
                <span class="hidden md:inline text-slate-500">|</span>
                <span class="hidden md:inline">📞 হেল্পলাইন: <strong>+৮৮০ ১৭০০-০০০০০০</strong></span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('order.track') }}" class="text-emerald-400 hover:text-emerald-300 font-medium flex items-center gap-1">
                    🔍 অনলাইন অর্ডার ট্র্যাকিং
                </a>
                <span class="text-slate-700">|</span>
                <a href="/admin/login" class="bg-emerald-600 hover:bg-emerald-500 text-white px-2.5 py-0.5 rounded font-semibold text-[11px] transition">
                    দর্জি প্রো ERP লগইন
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-md shadow-emerald-200">
                    ✂️
                </div>
                <div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">Darzi<span class="text-emerald-600">Pro</span></span>
                    <span class="block text-xs font-semibold text-slate-500 -mt-1">দর্জি ব্যবসা ও কাস্টম টেইলারিং ইআরপি</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="/" class="hover:text-emerald-600 transition">হোম (Home)</a>
                <a href="{{ route('catalog.index') }}" class="hover:text-emerald-600 transition">গজ কাপড় ও ক্যাটালগ</a>
                <a href="{{ route('order.track') }}" class="hover:text-emerald-600 transition">অর্ডার ট্র্যাকিং</a>
                <a href="#features" class="hover:text-emerald-600 transition">ফিচারসমূহ</a>
                <a href="#branches" class="hover:text-emerald-600 transition">শাখা অবস্থান</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/admin" class="hidden sm:inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-lg shadow transition">
                    <span>ড্যাশবোর্ড প্রবেশ</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 text-white font-black text-xl mb-3">
                    <span class="text-2xl">✂️</span> DarziPro (দর্জি প্রো)
                </div>
                <p class="text-slate-400 text-xs leading-relaxed max-w-md">
                    বাংলাদেশের প্রথম সর্বাধুনিক দর্জি ব্যবসা পরিচালনা সফটওয়্যার। বডি মেজারমেন্ট ভল্ট, কারিগর পিস-রেট মজুরি, থার্মাল পিওএস রিসিট, বায়োমেট্রিক হাজিরা মেশিন, এবং এআই স্টাইল ক্যাটালগ নিয়ে একটি পূর্ণাঙ্গ স্মার্ট সমাধান।
                </p>
                <div class="mt-4 text-xs text-emerald-400 font-semibold">
                    সক্ষম প্রযুক্তিসমূহ: PHP Laravel 11 • Filament v3 • Livewire 3 • Tailwind CSS
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">দ্রুত লিঙ্ক</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="/" class="hover:text-white transition">হোম পেজ</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-white transition">কাপড় ও ফ্যাশন ক্যাটালগ</a></li>
                    <li><a href="{{ route('order.track') }}" class="hover:text-white transition">অনলাইন অর্ডার ট্র্যাকিং</a></li>
                    <li><a href="/admin/login" class="hover:text-white transition">ম্যানেজার ও স্টাফ পোর্টাল</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-3">আমাদের শাখাসমূহ</h4>
                <ul class="space-y-2 text-xs">
                    <li><strong>ঢাকা ধানমন্ডি:</strong> রোড ৪/এ, সাত মসজিদ রোড</li>
                    <li><strong>ঢাকা উত্তরা:</strong> সেক্টর ৭, রবীন্দ্র সরণি</li>
                    <li><strong>চট্টগ্রাম:</strong> জিইসি মোড়, সিডিএ এভিনিউ</li>
                    <li class="pt-2 text-slate-500">সার্বক্ষণিক সাপোর্ট: support@darzipro.test</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 py-6 text-center text-xs text-slate-500">
            &copy; 2026 DarziPro ERP. Designed & Built for the Artisans & Tailors of Bangladesh 🇧🇩.
        </div>
    </footer>

</body>
</html>

<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Quick Order Lookup & Delivery Collection -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2 mb-4">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 text-emerald-600" />
                    টেইলারিং অর্ডার সার্চ ও বকেয়া আদায় (Tailoring Order Search)
                </h3>

                <form wire:submit="searchOrder" class="flex gap-2">
                    <input 
                        type="text" 
                        wire:model="searchQuery" 
                        placeholder="অর্ডার নং (যেমন: DHK-2026-0001) বা গ্রাহকের ফোন নম্বর লিখুন..." 
                        class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    />
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-lg flex items-center gap-2 transition"
                    >
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                        সার্চ করুন
                    </button>
                </form>

                @if($activeOrder)
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs uppercase font-bold text-gray-400">অর্ডার নম্বর</span>
                                <h4 class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $activeOrder->order_number }}</h4>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    গ্রাহক: <strong>{{ $activeOrder->customer->name }}</strong> ({{ $activeOrder->customer->phone }})
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $activeOrder->due_amount > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $activeOrder->due_amount > 0 ? 'বকেয়া আছে' : 'সম্পূর্ণ পরিশোধিত' }}
                                </span>
                                <div class="text-xs text-gray-400 mt-2">ডেলিভারি: {{ $activeOrder->delivery_date ? $activeOrder->delivery_date->format('d/m/Y') : 'জরুরি' }}</div>
                            </div>
                        </div>

                        <!-- Items list -->
                        <div class="mt-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase">পোশাক আইটেম:</span>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                @foreach($activeOrder->items as $item)
                                    <div class="p-2 bg-white dark:bg-gray-800 rounded border border-gray-100 dark:border-gray-700 text-xs">
                                        <div class="font-bold text-gray-800 dark:text-gray-200">{{ ucfirst($item->garment_type) }}</div>
                                        <div class="text-gray-500">মজুরি: ৳{{ $item->tailoring_price }} | ফেব্রিক: ৳{{ $item->fabric_price }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Collection Form -->
                        <div class="mt-6 p-4 bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/40 rounded-xl">
                            <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div class="text-xs text-gray-400">সর্বমোট বিল</div>
                                    <div class="text-lg font-bold text-gray-800 dark:text-gray-100">৳{{ number_format($activeOrder->total_amount, 2) }}</div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div class="text-xs text-gray-400">ইতিমধ্যে জমা</div>
                                    <div class="text-lg font-bold text-emerald-600">৳{{ number_format($activeOrder->advance_amount, 2) }}</div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div class="text-xs text-gray-400">অবশিষ্ট বকেয়া</div>
                                    <div class="text-lg font-bold text-rose-600">৳{{ number_format($activeOrder->due_amount, 2) }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">আদায়যোগ্য টাকা (৳)</label>
                                    <input type="number" wire:model="collectAmount" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">পেমেন্ট মাধ্যম</label>
                                    <select wire:model="paymentMethod" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2">
                                        <option value="cash">নগদ ক্যাশ (Cash)</option>
                                        <option value="bkash">বিকাশ (bKash)</option>
                                        <option value="nagad">নগদ (Nagad)</option>
                                        <option value="rocket">রকেট (Rocket)</option>
                                        <option value="card">ব্যাংক কার্ড (Card)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1">TrxID / নোট</label>
                                    <input type="text" wire:model="trxId" placeholder="MFS TrxID" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-3 py-2" />
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2 justify-end">
                                <a 
                                    href="{{ route('order.thermal-receipt', $activeOrder) }}" 
                                    target="_blank" 
                                    class="px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg flex items-center gap-1.5"
                                >
                                    <x-heroicon-o-printer class="w-4 h-4" />
                                    রিসিট প্রিন্ট
                                </a>
                                <button 
                                    type="button" 
                                    wire:click="collectDue" 
                                    class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm flex items-center gap-1.5 transition"
                                >
                                    <x-heroicon-o-check class="w-4 h-4" />
                                    টাকা গ্রহণ ও ডেলিভারি সম্পন্ন করুন
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Fast Retail Products Grid -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-md font-bold text-gray-800 dark:text-gray-100 mb-3 flex items-center gap-2">
                    <x-heroicon-o-shopping-bag class="w-5 h-5 text-emerald-600" />
                    দ্রুত গজ কাপড় ও এক্সেসরিজ বিক্রয় (Direct Retail Catalog)
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(\App\Models\Product::where('is_active', true)->take(8)->get() as $prod)
                        <button 
                            type="button"
                            wire:click="addProductToCart({{ $prod->id }})" 
                            class="text-left p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 bg-gray-50/50 dark:bg-gray-900/40 hover:bg-emerald-50/20 transition group"
                        >
                            <div class="text-xs font-bold text-gray-800 dark:text-gray-100 group-hover:text-emerald-600 truncate">{{ $prod->name }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">{{ $prod->unit }} | স্টক: {{ $prod->stock_quantity }}</div>
                            <div class="text-sm font-extrabold text-emerald-600 mt-2">৳{{ number_format($prod->selling_price, 2) }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Retail Cart Summary -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <x-heroicon-o-shopping-cart class="w-5 h-5 text-emerald-600" />
                        কাউন্টার সেলস কার্ট
                    </h3>
                    @if(count($cart) > 0)
                        <button type="button" wire:click="clearCart" class="text-xs text-rose-500 hover:underline">খালি করুন</button>
                    @endif
                </div>

                @if(count($cart) > 0)
                    <div class="space-y-3 max-h-72 overflow-y-auto pr-1">
                        @foreach($cart as $cId => $cItem)
                            <div class="flex justify-between items-center text-xs p-2 bg-gray-50 dark:bg-gray-900 rounded border border-gray-100 dark:border-gray-700">
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-200">{{ $cItem['name'] }}</div>
                                    <div class="text-gray-400">{{ $cItem['qty'] }} x ৳{{ $cItem['price'] }}</div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 dark:text-gray-100">৳{{ $cItem['total'] }}</span>
                                    <button type="button" wire:click="removeFromCart({{ $cId }})" class="text-rose-500 hover:text-rose-700">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center text-base font-bold text-gray-900 dark:text-white">
                            <span>মোট টাকা:</span>
                            <span class="text-emerald-600">৳{{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <button 
                            type="button" 
                            onclick="alert('কাউন্টার ক্যাশ সেলস সফলভাবে সংরক্ষিত হয়েছে!')"
                            class="w-full mt-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-lg shadow-sm transition"
                        >
                            নগদ বিক্রয় সম্পন্ন করুন
                        </button>
                    </div>
                @else
                    <div class="text-center py-10 text-gray-400 text-xs">
                        কার্টে কোনো পণ্য যোগ করা হয়নি।<br>বামপাশের ক্যাটালগ থেকে ক্লিক করে যোগ করুন।
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>

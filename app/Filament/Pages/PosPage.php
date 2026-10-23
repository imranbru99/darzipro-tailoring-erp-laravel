<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use App\Models\Product;
use App\Models\TailoringOrder;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Rule;

class PosPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'দর্জি ও অর্ডার ব্যবস্থাপনা';

    protected static ?string $navigationLabel = 'কাউন্টার পিওএস (Fast POS)';

    protected static ?string $title = 'কাউন্টার পিওএস ও বিলিং (Counter Billing POS)';

    protected static string $view = 'filament.pages.pos-page';

    protected static ?int $navigationSort = 2;

    public string $searchQuery = '';
    public ?int $selectedOrderId = null;
    public ?TailoringOrder $activeOrder = null;

    public float $collectAmount = 0.00;
    public string $paymentMethod = 'cash';
    public string $trxId = '';

    // Direct Retail Cart
    public array $cart = [];
    public float $cartTotal = 0.00;

    public function searchOrder(): void
    {
        if (empty($this->searchQuery)) {
            Notification::make()->title('অনুগ্রহ করে অর্ডার নং বা ফোন নম্বর লিখুন')->warning()->send();
            return;
        }

        $order = TailoringOrder::with(['customer', 'items'])
            ->where('order_number', 'like', "%{$this->searchQuery}%")
            ->orWhereHas('customer', function ($q) {
                $q->where('phone', 'like', "%{$this->searchQuery}%")
                  ->orWhere('name', 'like', "%{$this->searchQuery}%");
            })
            ->latest()
            ->first();

        if ($order) {
            $this->activeOrder = $order;
            $this->selectedOrderId = $order->id;
            $this->collectAmount = (float)$order->due_amount;
            Notification::make()->title("অর্ডার #{$order->order_number} পাওয়া গেছে")->success()->send();
        } else {
            $this->activeOrder = null;
            $this->selectedOrderId = null;
            Notification::make()->title('কোনো অর্ডার পাওয়া যায়নি')->danger()->send();
        }
    }

    public function collectDue(): void
    {
        if (!$this->activeOrder) {
            return;
        }

        $pay = (float)$this->collectAmount;
        if ($pay <= 0) {
            Notification::make()->title('টাকার পরিমাণ লিখুন')->warning()->send();
            return;
        }

        $order = $this->activeOrder;
        $order->advance_amount += $pay;
        $order->due_amount = max(0, $order->total_amount - $order->advance_amount);
        $order->payment_method = $this->paymentMethod;
        if ($this->trxId) {
            $order->transaction_reference = $this->trxId;
        }

        if ($order->due_amount <= 0) {
            $order->payment_status = 'paid';
            $order->order_status = 'delivered';
        } else {
            $order->payment_status = 'partial';
        }

        $order->save();
        $this->activeOrder = $order->fresh();
        $this->collectAmount = (float)$this->activeOrder->due_amount;

        Notification::make()
            ->title("৳{$pay} সফলভাবে সংগ্রহ করা হয়েছে!")
            ->success()
            ->send();
    }

    public function addProductToCart(int $productId): void
    {
        $product = Product::find($productId);
        if (!$product) return;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty'] += 1;
            $this->cart[$productId]['total'] = $this->cart[$productId]['qty'] * $product->selling_price;
        } else {
            $this->cart[$productId] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float)$product->selling_price,
                'qty'   => 1,
                'total' => (float)$product->selling_price,
            ];
        }

        $this->calculateCart();
    }

    public function removeFromCart(int $productId): void
    {
        unset($this->cart[$productId]);
        $this->calculateCart();
    }

    public function calculateCart(): void
    {
        $this->cartTotal = array_sum(array_column($this->cart, 'total'));
    }

    public function clearCart(): void
    {
        $this->cart = [];
        $this->cartTotal = 0;
    }
}

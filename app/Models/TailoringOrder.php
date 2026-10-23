<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TailoringOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'customer_id',
        'created_by',
        'order_number',
        'token_pin',
        'subtotal',
        'discount_amount',
        'total_amount',
        'advance_amount',
        'due_amount',
        'payment_status',
        'order_status',
        'payment_method',
        'transaction_reference',
        'trial_date',
        'delivery_date',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'trial_date' => 'date',
        'delivery_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (TailoringOrder $order) {
            if (empty($order->order_number)) {
                $prefix = $order->branch ? $order->branch->code : 'ORD';
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $order->order_number = sprintf('%s-%s-%04d', $prefix, $year, $count);
            }

            if (empty($order->token_pin)) {
                $order->token_pin = (string) mt_rand(1000, 9999);
            }

            // Calculate due amount
            $order->due_amount = max(0, $order->total_amount - $order->advance_amount);
            if ($order->due_amount <= 0 && $order->total_amount > 0) {
                $order->payment_status = 'paid';
            } elseif ($order->advance_amount > 0) {
                $order->payment_status = 'partial';
            } else {
                $order->payment_status = 'unpaid';
            }
        });
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TailoringOrderItem::class);
    }
}

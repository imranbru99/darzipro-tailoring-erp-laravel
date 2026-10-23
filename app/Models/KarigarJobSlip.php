<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KarigarJobSlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'tailoring_order_item_id',
        'karigar_id',
        'task_type',
        'rate',
        'status',
        'notes',
        'completed_at',
        'paid_at',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'completed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(TailoringOrderItem::class, 'tailoring_order_item_id');
    }

    public function karigar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karigar_id');
    }

    public function isWagePaid(): bool
    {
        return $this->paid_at !== null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TailoringOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tailoring_order_id',
        'measurement_profile_id',
        'garment_type',
        'fabric_source',
        'fabric_product_id',
        'fabric_yards_used',
        'tailoring_price',
        'fabric_price',
        'subtotal',
        'style_attributes',
        'custom_measurements',
        'special_instructions',
        'item_status',
    ];

    protected $casts = [
        'fabric_yards_used' => 'decimal:2',
        'tailoring_price' => 'decimal:2',
        'fabric_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'style_attributes' => 'array',
        'custom_measurements' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TailoringOrder::class, 'tailoring_order_id');
    }

    public function measurementProfile(): BelongsTo
    {
        return $this->belongsTo(MeasurementProfile::class);
    }

    public function fabricProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'fabric_product_id');
    }

    public function jobSlips(): HasMany
    {
        return $this->hasMany(KarigarJobSlip::class, 'tailoring_order_item_id');
    }
}

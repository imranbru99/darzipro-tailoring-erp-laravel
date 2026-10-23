<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ImranDev\UniversalSlug\SlugOptions;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

class Product extends Model
{
    use HasFactory, HasUniversalSlug;

    protected $fillable = [
        'category_id',
        'branch_id',
        'name',
        'bangla_name',
        'slug',
        'sku',
        'product_type', // fabric, readymade, accessory, trimming
        'unit', // yard, meter, piece, roll
        'cost_price',
        'selling_price',
        'stock_quantity',
        'low_stock_threshold',
        'fabric_composition',
        'color',
        'image',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'low_stock_threshold' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(TailoringOrderItem::class, 'fabric_product_id');
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_threshold;
    }
}

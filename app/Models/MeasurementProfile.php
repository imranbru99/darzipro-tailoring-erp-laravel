<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'title',
        'garment_type',
        'measurements',
        'notes',
        'is_default',
    ];

    protected $casts = [
        'measurements' => 'array',
        'is_default' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

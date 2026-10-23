<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'phone',
        'email',
        'address',
        'gender',
        'loyalty_points',
        'special_notes',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function measurementProfiles(): HasMany
    {
        return $this->hasMany(MeasurementProfile::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(TailoringOrder::class);
    }
}

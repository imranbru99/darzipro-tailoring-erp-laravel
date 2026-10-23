<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KarigarRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'garment_type',
        'task_type',
        'default_rate',
    ];

    protected $casts = [
        'default_rate' => 'decimal:2',
    ];
}

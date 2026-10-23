<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'user_id',
        'device_id',
        'punch_time',
        'punch_type', // check_in, check_out
        'verification_mode', // fingerprint, rfid, face, manual
        'sync_status',
        'notes',
    ];

    protected $casts = [
        'punch_time' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

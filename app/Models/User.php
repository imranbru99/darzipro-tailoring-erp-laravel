<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'phone',
        'role',
        'hourly_rate',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'hourly_rate' => 'decimal:2',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Super admin, managers, cutters, karigars, and cashiers can access the admin ERP panel
        return $this->is_active && in_array($this->role, [
            'super_admin',
            'branch_manager',
            'master_cutter',
            'karigar',
            'pos_cashier',
        ]);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function jobSlips(): HasMany
    {
        return $this->hasMany(KarigarJobSlip::class, 'karigar_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isBranchManager(): bool
    {
        return $this->role === 'branch_manager';
    }

    public function isKarigar(): bool
    {
        return $this->role === 'karigar';
    }

    public function isMasterCutter(): bool
    {
        return $this->role === 'master_cutter';
    }
}

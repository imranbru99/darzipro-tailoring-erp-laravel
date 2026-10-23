<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'module_key',
        'name',
        'bangla_name',
        'description',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Check if a module is active globally or for a specific branch.
     */
    public static function isModuleActive(string $key, ?int $branchId = null): bool
    {
        $query = static::where('module_key', $key);

        if ($branchId) {
            $branchSetting = (clone $query)->where('branch_id', $branchId)->first();
            if ($branchSetting !== null) {
                return $branchSetting->is_enabled;
            }
        }

        // Check global default
        $globalSetting = $query->whereNull('branch_id')->first();
        return $globalSetting ? $globalSetting->is_enabled : true;
    }
}

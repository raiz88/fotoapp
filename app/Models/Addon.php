<?php

namespace App\Models;

use App\Casts\Money as MoneyCast;
use App\Models\Concerns\BelongsToBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use BelongsToBrand, HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id', 'code', 'name', 'description', 'price_cents',
        'unit', 'min_qty', 'max_qty', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_cents' => MoneyCast::class,
            'is_active' => 'boolean',
        ];
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'addon_package')
            ->withPivot(['price_override_cents', 'is_recommended', 'sort_order']);
    }
}

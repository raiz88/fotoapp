<?php

namespace App\Models\Concerns;

use App\Models\Brand;
use App\Scopes\BrandScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToBrand
{
    public static function bootBelongsToBrand(): void
    {
        static::addGlobalScope(new BrandScope);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function scopeForBrand(Builder $query, Brand|int $brand): Builder
    {
        return $query->where('brand_id', $brand instanceof Brand ? $brand->id : $brand);
    }
}

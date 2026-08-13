<?php

namespace App\Scopes;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Automatically scopes brand-owned models to the currently resolved brand.
 *
 * Only active while $enabled is true — the public/portal middleware group
 * turns it on for the duration of the request. Admin routes never enable
 * it, since admin must be able to see and aggregate across both brands.
 */
class BrandScope implements Scope
{
    public static bool $enabled = false;

    public function apply(Builder $builder, Model $model): void
    {
        if (! static::$enabled) {
            return;
        }

        if (! app()->bound(Brand::class)) {
            return;
        }

        $builder->where($model->getTable().'.brand_id', app(Brand::class)->id);
    }
}

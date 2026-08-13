<?php

namespace App\Casts;

use App\ValueObjects\Money as MoneyValue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Casts an integer "cents" column to a Money value object.
 *
 * @implements CastsAttributes<MoneyValue|null, MoneyValue|int|null>
 */
class Money implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?MoneyValue
    {
        return is_null($value) ? null : new MoneyValue((int) $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        if (is_null($value)) {
            return null;
        }

        return $value instanceof MoneyValue ? $value->cents : (int) $value;
    }
}

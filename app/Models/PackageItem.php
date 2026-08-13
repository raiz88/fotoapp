<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    protected $fillable = [
        'package_id', 'label', 'detail', 'icon', 'is_highlight', 'is_included', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_highlight' => 'boolean',
            'is_included' => 'boolean',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}

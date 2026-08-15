<?php

namespace App\Models;

use App\Casts\Money as MoneyCast;
use App\Models\Concerns\BelongsToBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use BelongsToBrand, HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id', 'slug', 'name', 'tier', 'tagline', 'description',
        'price_cents', 'was_price_cents', 'price_note',
        'deposit_percent', 'deposit_fixed_cents',
        'duration_minutes', 'session_slots_required', 'max_pax',
        'edited_photos_count', 'raw_photos_included', 'delivery_days', 'travel_included_km',
        'cover_image_path', 'gallery', 'terms_override',
        'is_active', 'is_featured', 'sort_order', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price_cents' => MoneyCast::class,
            'was_price_cents' => MoneyCast::class,
            'deposit_fixed_cents' => MoneyCast::class,
            'gallery' => 'array',
            'raw_photos_included' => 'boolean',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(PackageItem::class)->orderBy('sort_order');
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'addon_package')
            ->withPivot(['price_override_cents', 'is_recommended', 'sort_order'])
            ->orderByPivot('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)->whereNotNull('published_at');
    }

    public function depositPercent(): int
    {
        return $this->deposit_percent ?? $this->brand->deposit_percent;
    }

    /**
     * A flat deposit (deposit_fixed_cents) takes priority over the
     * percent-based deposit when a package has one set.
     */
    public function depositLabel(): string
    {
        return $this->deposit_fixed_cents
            ? $this->deposit_fixed_cents->format()
            : $this->depositPercent().'%';
    }

    public function whatsappMessage(): string
    {
        return "Saya berminat dengan {$this->name} ({$this->price_cents->format()}).";
    }
}

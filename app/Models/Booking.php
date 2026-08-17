<?php

namespace App\Models;

use App\Casts\Money as MoneyCast;
use App\Models\Concerns\BelongsToBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use BelongsToBrand, HasFactory;

    /**
     * Fixed daily slots — a solo photographer can only cover one shoot per
     * slot, so a slot is either free or fully booked (no duration math).
     */
    public const SLOTS = [
        'morning' => 'Morning (9:00 AM – 12:00 PM)',
        'afternoon' => 'Afternoon (1:00 PM – 4:00 PM)',
        'evening' => 'Evening (5:00 PM – 8:00 PM)',
    ];

    public const STATUS_PENDING_PAYMENT = 'pending_payment';

    public const STATUS_PAID = 'paid';

    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'brand_id', 'package_id', 'customer_name', 'customer_email', 'customer_phone',
        'booking_date', 'time_slot', 'notes',
        'status', 'deposit_amount_cents', 'access_token', 'gateway_bill_code', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'deposit_amount_cents' => MoneyCast::class,
            'paid_at' => 'datetime',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function slotLabel(): string
    {
        return self::SLOTS[$this->time_slot] ?? $this->time_slot;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function trackingUrl(): string
    {
        return $this->brand->publicUrl().route('booking.show', $this->access_token, absolute: false);
    }
}

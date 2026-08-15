<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBrand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $fillable = [
        'brand_id', 'package_id', 'customer_name', 'customer_phone',
        'booking_date', 'time_slot', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function slotLabel(): string
    {
        return self::SLOTS[$this->time_slot] ?? $this->time_slot;
    }
}

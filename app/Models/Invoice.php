<?php

namespace App\Models;

use App\Casts\Money as MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'invoice_number', 'amount_cents', 'pdf_path', 'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'amount_cents' => MoneyCast::class,
            'issued_at' => 'datetime',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

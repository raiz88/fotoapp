<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'email',
        'phone',
        'package',
        'booking_date',
        'booking_time',
        'location',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'price' => 'decimal:2',
    ];

    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];
}

<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Brand;
use Illuminate\Console\Command;

class ExpireStaleBookings extends Command
{
    protected $signature = 'bookings:expire-stale';

    protected $description = 'Expire pending_payment bookings past their brand\'s payment_hold_hours, freeing the slot';

    public function handle(): void
    {
        $expired = 0;

        Brand::all()->each(function (Brand $brand) use (&$expired) {
            $expired += Booking::query()
                ->forBrand($brand)
                ->where('status', Booking::STATUS_PENDING_PAYMENT)
                ->where('created_at', '<=', now()->subHours($brand->payment_hold_hours))
                ->update(['status' => Booking::STATUS_EXPIRED]);
        });

        $this->info("Expired {$expired} stale booking(s).");
    }
}

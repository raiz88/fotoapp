<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', Rule::in(array_keys(Booking::SLOTS))],
            'package_id' => ['nullable', 'exists:packages,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $slotTaken = Booking::where('brand_id', $brand->id)
            ->where('booking_date', $validated['booking_date'])
            ->where('time_slot', $validated['time_slot'])
            ->exists();

        if ($slotTaken) {
            return back()->withInput()->withErrors([
                'time_slot' => 'That date and time slot is already booked. Please choose another date or slot.',
            ]);
        }

        try {
            Booking::create([...$validated, 'brand_id' => $brand->id]);
        } catch (QueryException) {
            // Unique constraint race: someone booked the same slot a moment ago.
            return back()->withInput()->withErrors([
                'time_slot' => 'That date and time slot was just booked by someone else. Please choose another.',
            ]);
        }

        return redirect(route('home').'#booking')->with('booking_confirmed', true);
    }
}

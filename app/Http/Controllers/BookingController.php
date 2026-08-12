<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderBy('booking_date', 'desc')->get();

        $rows = $bookings->map(function ($b) {
            $badge = match ($b->status) {
                'confirmed' => 'success',
                'completed' => 'info',
                'cancelled' => 'danger',
                default     => 'warning',
            };
            return [
                'id'      => $b->id,
                'client'  => e($b->client_name),
                'email'   => e($b->email ?: '-'),
                'package' => e($b->package ?: '-'),
                'date'    => $b->booking_date->format('d M Y'),
                'time'    => e($b->booking_time ?: '-'),
                'price'   => 'RM ' . number_format($b->price, 2),
                'status'  => ucfirst($b->status),
                'badge'   => $badge,
            ];
        })->values();

        return view('bookings.index', compact('rows'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'  => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'package'      => 'nullable|string|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'nullable',
            'location'     => 'nullable|string|max:255',
            'price'        => 'nullable|numeric|min:0',
            'status'       => 'nullable|in:pending,confirmed,completed,cancelled',
            'notes'        => 'nullable|string',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking untuk ' . $validated['client_name'] . ' berjaya disimpan.');
    }

    public function calendar()
    {
        $bookings = Booking::all();

        $events = $bookings->map(function ($b) {
            $colors = [
                'confirmed' => '#0ab39c',
                'completed' => '#405189',
                'cancelled' => '#f06548',
                'pending'   => '#f7b84b',
            ];
            return [
                'id'    => $b->id,
                'title' => $b->client_name . ($b->package ? ' — ' . $b->package : ''),
                'start' => $b->booking_date->format('Y-m-d') . ($b->booking_time ? 'T' . $b->booking_time : ''),
                'color' => $colors[$b->status] ?? '#f7b84b',
            ];
        })->values();

        return view('bookings.calendar', compact('events'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
            ->with('success', 'Booking dihapuskan.');
    }
}

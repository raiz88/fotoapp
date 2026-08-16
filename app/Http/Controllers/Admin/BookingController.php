<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\InvoiceService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['brand', 'package', 'invoice'])
            ->orderByDesc('booking_date')
            ->paginate(25);

        return view('admin.bookings.index', ['bookings' => $bookings]);
    }

    public function show(Booking $booking): View
    {
        $booking->load(['brand', 'package', 'invoice']);

        return view('admin.bookings.show', ['booking' => $booking]);
    }

    public function invoice(Booking $booking, InvoiceService $invoices): StreamedResponse
    {
        abort_unless($booking->isPaid(), 404);

        $invoice = $booking->invoice ?? $invoices->generate($booking);

        return Storage::disk('local')->download($invoice->pdf_path, "{$invoice->invoice_number}.pdf");
    }
}

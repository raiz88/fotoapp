<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    /**
     * Idempotent: returns the existing invoice if one was already generated
     * for this booking (e.g. a retried webhook), rather than duplicating it.
     */
    public function generate(Booking $booking): Invoice
    {
        if ($booking->invoice) {
            return $booking->invoice;
        }

        return DB::transaction(function () use ($booking) {
            $brand = $booking->brand;
            $sequence = Invoice::whereHas('booking', fn ($query) => $query->where('brand_id', $brand->id))->count() + 1;
            $invoiceNumber = sprintf('%s-INV-%06d', $brand->document_prefix, $sequence);
            $issuedAt = now();

            $pdf = Pdf::loadView('pdf.invoice', [
                'booking' => $booking,
                'brand' => $brand,
                'invoiceNumber' => $invoiceNumber,
                'issuedAt' => $issuedAt,
            ]);

            $path = "invoices/{$brand->code}/{$invoiceNumber}.pdf";
            Storage::disk('local')->put($path, $pdf->output());

            return Invoice::create([
                'booking_id' => $booking->id,
                'invoice_number' => $invoiceNumber,
                'amount_cents' => $booking->deposit_amount_cents->cents,
                'pdf_path' => $path,
                'issued_at' => $issuedAt,
            ]);
        });
    }
}

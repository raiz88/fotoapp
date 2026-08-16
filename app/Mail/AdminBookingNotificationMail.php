<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->loadMissing(['brand', 'package', 'invoice']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Paid Booking — {$this->booking->invoice->invoice_number}",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.admin-booking-notification');
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('local', $this->booking->invoice->pdf_path)
                ->as("{$this->booking->invoice->invoice_number}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}

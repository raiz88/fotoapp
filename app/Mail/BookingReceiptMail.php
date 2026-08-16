<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->loadMissing(['brand', 'package', 'invoice']);
    }

    public function envelope(): Envelope
    {
        $brand = $this->booking->brand;

        return new Envelope(
            from: new Address($brand->mail_from_address, $brand->mail_from_name),
            replyTo: $brand->reply_to_address ? [new Address($brand->reply_to_address)] : [],
            subject: "Booking Confirmed — {$this->booking->invoice->invoice_number}",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.booking-receipt');
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

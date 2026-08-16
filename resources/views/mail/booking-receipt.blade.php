<x-mail::message>
# Booking Confirmed

Hi {{ $booking->customer_name }},

Your deposit of **{{ $booking->deposit_amount_cents->format() }}** has been received for **{{ $booking->package->name }}** on **{{ $booking->booking_date->toFormattedDateString() }} ({{ $booking->slotLabel() }})**.

Your invoice is attached to this email as a PDF ({{ $booking->invoice->invoice_number }}).

<x-mail::button :url="$booking->trackingUrl()">
View Booking
</x-mail::button>

Thanks,<br>
{{ $booking->brand->name }}
</x-mail::message>

<x-mail::message>
# New Paid Booking

**Brand:** {{ $booking->brand->name }}<br>
**Customer:** {{ $booking->customer_name }} ({{ $booking->customer_email }}, {{ $booking->customer_phone }})<br>
**Package:** {{ $booking->package->name }}<br>
**Date:** {{ $booking->booking_date->toFormattedDateString() }} — {{ $booking->slotLabel() }}<br>
**Deposit Paid:** {{ $booking->deposit_amount_cents->format() }}<br>
**Invoice:** {{ $booking->invoice->invoice_number }} (attached)

<x-mail::button :url="route('admin.bookings.show', $booking)">
View in Admin Panel
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>

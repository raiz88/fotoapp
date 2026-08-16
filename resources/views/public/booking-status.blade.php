@extends('public.layouts.brand')

@section('title', 'Your Booking')

@section('content')
    <section class="relative mx-auto max-w-xl px-4 py-32">
        <div class="text-center">
            <p class="font-display text-xs font-semibold uppercase tracking-[0.3em] text-brand-primary">Booking</p>
            <h1 class="font-display mt-4 text-3xl font-bold text-fg md:text-4xl">
                @if ($booking->isPaid())
                    Booking Confirmed
                @elseif ($booking->status === \App\Models\Booking::STATUS_EXPIRED)
                    Booking Expired
                @else
                    Awaiting Payment
                @endif
            </h1>
        </div>

        <div class="glass-card glow-border mt-8 rounded-3xl p-8">
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-fg/50">Package</dt>
                    <dd class="text-fg">{{ $booking->package->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-fg/50">Date &amp; Slot</dt>
                    <dd class="text-fg">{{ $booking->booking_date->toFormattedDateString() }} — {{ $booking->slotLabel() }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-fg/50">Deposit</dt>
                    <dd class="text-fg">{{ $booking->deposit_amount_cents->format() }}</dd>
                </div>
            </dl>

            <div class="mt-8 border-t border-fg/10 pt-6 text-center">
                @if ($booking->isPaid())
                    <p class="text-sm text-fg/60">A receipt has been emailed to {{ $booking->customer_email }}.</p>
                    <a href="{{ route('booking.invoice', $booking->access_token) }}"
                       class="mt-5 inline-block w-full rounded-full bg-brand-primary py-3 font-semibold text-black shadow-[0_0_30px_-8px_var(--brand-primary)] transition hover:brightness-110">
                        Download Invoice ({{ $booking->invoice?->invoice_number }})
                    </a>
                @elseif ($booking->status === \App\Models\Booking::STATUS_EXPIRED)
                    <p class="text-sm text-fg/60">This booking expired before payment was completed. Please book again.</p>
                    <a href="{{ route('home') }}#booking" class="mt-5 inline-block w-full rounded-full bg-brand-primary py-3 font-semibold text-black">
                        Book Again
                    </a>
                @else
                    <p class="text-sm text-fg/60">We haven't received your deposit payment yet. If you already paid, this page will update automatically once confirmed.</p>
                @endif
            </div>
        </div>
    </section>
@endsection

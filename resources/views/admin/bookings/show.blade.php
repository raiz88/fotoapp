@extends('layouts.app')

@section('title', 'Tempahan #'.$booking->id)

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Tempahan #{{ $booking->id }}</h4>
            <p class="text-muted mb-0">{{ $booking->brand->name }}</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-soft-secondary">Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Butiran Pelanggan</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $booking->customer_name }}</dd>
                        <dt class="col-sm-4">Emel</dt>
                        <dd class="col-sm-8">{{ $booking->customer_email }}</dd>
                        <dt class="col-sm-4">Telefon</dt>
                        <dd class="col-sm-8">{{ $booking->customer_phone }}</dd>
                        <dt class="col-sm-4">Pakej</dt>
                        <dd class="col-sm-8">{{ $booking->package?->name ?? '—' }}</dd>
                        <dt class="col-sm-4">Tarikh &amp; Slot</dt>
                        <dd class="col-sm-8">{{ $booking->booking_date->toFormattedDateString() }} — {{ $booking->slotLabel() }}</dd>
                        @if ($booking->notes)
                            <dt class="col-sm-4">Nota</dt>
                            <dd class="col-sm-8">{{ $booking->notes }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pembayaran</h5>
                    <dl class="row mb-3">
                        <dt class="col-sm-6">Status</dt>
                        <dd class="col-sm-6">
                            @if ($booking->status === \App\Models\Booking::STATUS_PAID)
                                <span class="badge bg-success-subtle text-success">Dibayar</span>
                            @elseif ($booking->status === \App\Models\Booking::STATUS_EXPIRED)
                                <span class="badge bg-secondary-subtle text-secondary">Luput</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Menunggu Bayaran</span>
                            @endif
                        </dd>
                        <dt class="col-sm-6">Deposit</dt>
                        <dd class="col-sm-6">{{ $booking->deposit_amount_cents->format() }}</dd>
                        @if ($booking->paid_at)
                            <dt class="col-sm-6">Dibayar Pada</dt>
                            <dd class="col-sm-6">{{ $booking->paid_at->format('d/m/Y H:i') }}</dd>
                        @endif
                    </dl>

                    @if ($booking->isPaid())
                        <a href="{{ route('admin.bookings.invoice', $booking) }}" class="btn btn-success w-100">
                            <i class="ri-download-2-line align-bottom me-1"></i>
                            Muat Turun Invois {{ $booking->invoice?->invoice_number }}
                        </a>
                    @else
                        <p class="text-muted mb-0">Invois akan dijana secara automatik sebaik deposit disahkan oleh gateway pembayaran.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

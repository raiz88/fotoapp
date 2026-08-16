@extends('layouts.app')

@section('title', 'Tempahan')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Tempahan</h4>
        <p class="text-muted mb-0">Semua tempahan merentasi brand, termasuk status pembayaran deposit.</p>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Brand</th>
                        <th>Pelanggan</th>
                        <th>Pakej</th>
                        <th>Tarikh &amp; Slot</th>
                        <th>Deposit</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->brand->name }}</td>
                            <td>
                                {{ $booking->customer_name }}
                                <div class="small text-muted">{{ $booking->customer_email }}</div>
                            </td>
                            <td>{{ $booking->package?->name ?? '—' }}</td>
                            <td>
                                {{ $booking->booking_date->toFormattedDateString() }}
                                <div class="small text-muted">{{ $booking->slotLabel() }}</div>
                            </td>
                            <td>{{ $booking->deposit_amount_cents->format() }}</td>
                            <td>
                                @if ($booking->status === \App\Models\Booking::STATUS_PAID)
                                    <span class="badge bg-success-subtle text-success">Dibayar</span>
                                @elseif ($booking->status === \App\Models\Booking::STATUS_EXPIRED)
                                    <span class="badge bg-secondary-subtle text-secondary">Luput</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Menunggu Bayaran</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-soft-primary">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Tiada tempahan lagi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bookings->hasPages())
            <div class="card-footer">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-sm-0">Dashboard</h4>
                <p class="text-muted mb-0 mt-1">Ringkasan booking studio fotografi</p>
            </div>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                <i class="ri-add-line align-bottom me-1"></i> New Booking
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate"><div class="card-body"><div class="d-flex align-items-center">
            <div class="flex-grow-1"><p class="text-uppercase fw-medium text-muted mb-0">Total Booking</p><h4 class="fs-22 fw-semibold mb-0 mt-2">{{ $totalBookings }}</h4></div>
            <div class="avatar-sm flex-shrink-0"><span class="avatar-title bg-primary-subtle text-primary rounded fs-3"><i class="ri-calendar-check-line"></i></span></div>
        </div></div></div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate"><div class="card-body"><div class="d-flex align-items-center">
            <div class="flex-grow-1"><p class="text-uppercase fw-medium text-muted mb-0">Upcoming</p><h4 class="fs-22 fw-semibold mb-0 mt-2">{{ $upcomingCount }}</h4></div>
            <div class="avatar-sm flex-shrink-0"><span class="avatar-title bg-info-subtle text-info rounded fs-3"><i class="ri-calendar-schedule-line"></i></span></div>
        </div></div></div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate"><div class="card-body"><div class="d-flex align-items-center">
            <div class="flex-grow-1"><p class="text-uppercase fw-medium text-muted mb-0">Confirmed</p><h4 class="fs-22 fw-semibold mb-0 mt-2">{{ $statusCounts['confirmed'] }}</h4></div>
            <div class="avatar-sm flex-shrink-0"><span class="avatar-title bg-success-subtle text-success rounded fs-3"><i class="ri-checkbox-circle-line"></i></span></div>
        </div></div></div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate"><div class="card-body"><div class="d-flex align-items-center">
            <div class="flex-grow-1"><p class="text-uppercase fw-medium text-muted mb-0">Revenue</p><h4 class="fs-22 fw-semibold mb-0 mt-2">RM {{ number_format($totalRevenue, 2) }}</h4></div>
            <div class="avatar-sm flex-shrink-0"><span class="avatar-title bg-warning-subtle text-warning rounded fs-3"><i class="ri-money-dollar-circle-line"></i></span></div>
        </div></div></div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card"><div class="card-header"><h5 class="card-title mb-0">Trend Booking</h5></div><div class="card-body"><div id="booking-trend-chart" class="apex-charts" style="height: 320px"></div></div></div>
    </div>
    <div class="col-xl-4">
        <div class="card"><div class="card-header"><h5 class="card-title mb-0">Status Booking</h5></div><div class="card-body"><div id="booking-status-chart" class="apex-charts" style="height: 320px"></div></div></div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card"><div class="card-header d-flex justify-content-between align-items-center"><h5 class="card-title mb-0">Booking Akan Datang</h5><a href="{{ route('bookings.index') }}" class="text-primary">Lihat semua</a></div>
            <div class="card-body"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Client</th><th>Package</th><th>Tarikh</th><th>Status</th></tr></thead><tbody>
                @forelse($upcomingBookings as $booking)
                    @php($badge = match($booking->status) { 'confirmed' => 'success', 'completed' => 'info', default => 'warning' })
                    <tr><td class="fw-medium">{{ $booking->client_name }}</td><td>{{ $booking->package ?: '-' }}</td><td>{{ $booking->booking_date->format('d M Y') }}{{ $booking->booking_time ? ' · ' . date('g:i A', strtotime($booking->booking_time)) : '' }}</td><td><span class="badge bg-{{ $badge }}-subtle text-{{ $badge }}">{{ ucfirst($booking->status) }}</span></td></tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada booking akan datang.</td></tr>
                @endforelse
            </tbody></table></div></div>
        </div>
    </div>
    <div class="col-xl-4"><div class="card"><div class="card-header"><h5 class="card-title mb-0">Ringkasan Status</h5></div><div class="card-body">
        <div class="d-flex justify-content-between border-bottom py-2"><span>Pending</span><strong>{{ $statusCounts['pending'] }}</strong></div>
        <div class="d-flex justify-content-between border-bottom py-2"><span>Confirmed</span><strong>{{ $statusCounts['confirmed'] }}</strong></div>
        <div class="d-flex justify-content-between border-bottom py-2"><span>Completed</span><strong>{{ $statusCounts['completed'] }}</strong></div>
        <div class="d-flex justify-content-between py-2"><span>Cancelled</span><strong>{{ $statusCounts['cancelled'] }}</strong></div>
    </div></div></div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('velzon/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new ApexCharts(document.querySelector('#booking-trend-chart'), {
        chart: { type: 'area', height: 320, toolbar: { show: false } }, series: [{ name: 'Booking', data: @json($monthlyBookings) }],
        xaxis: { categories: @json($monthLabels) }, colors: ['#405189'], stroke: { curve: 'smooth', width: 3 }, dataLabels: { enabled: false },
        yaxis: { min: 0, forceNiceScale: true }, grid: { borderColor: '#f1f1f1' }, tooltip: { y: { formatter: value => value + ' booking' } }
    }).render();
    new ApexCharts(document.querySelector('#booking-status-chart'), {
        chart: { type: 'donut', height: 320 }, labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'], series: @json($statusCounts->values()),
        colors: ['#f7b84b', '#0ab39c', '#405189', '#f06548'], legend: { position: 'bottom' }, dataLabels: { enabled: false }
    }).render();
});
</script>
@endpush

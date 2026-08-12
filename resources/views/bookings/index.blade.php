@extends('layouts.app')

@section('title', 'Booking List')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Booking List</h4>
            <div class="page-title-right">
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="ri-add-line align-bottom me-1"></i> New Booking
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="booking-grid"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('velzon/assets/libs/gridjs/theme/mermaid.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('velzon/assets/libs/gridjs/gridjs.umd.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookings = @json($rows);

        new gridjs.Grid({
            columns: [
                { name: 'ID', width: '60px' },
                { name: 'Client', formatter: (cell, row) => gridjs.html(`<div class="fw-semibold">${cell}</div><small class="text-muted">${row.cells[2].data}</small>`) },
                { name: 'Email', hidden: true },
                { name: 'Package', width: '130px' },
                { name: 'Date', width: '130px' },
                { name: 'Time', width: '90px' },
                { name: 'Price', width: '120px' },
                { name: 'Status', width: '130px', formatter: (cell, row) => gridjs.html(`<span class="badge bg-${row.cells[8].data}-subtle text-${row.cells[8].data}">${cell}</span>`) },
                { name: 'badge', hidden: true },
                { name: 'Action', width: '100px', formatter: (cell) => gridjs.html(cell) },
            ],
            data: bookings.map(b => [
                b.id,
                b.client,
                b.email,
                b.package,
                b.date,
                b.time,
                b.price,
                b.status.charAt(0).toUpperCase() + b.status.slice(1),
                b.badge,
                `<form action="/bookings/${b.id}" method="POST" onsubmit="return confirm('Buang booking ini?')" class="d-inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line"></i></button>
                </form>`,
            ]),
            pagination: { limit: 10 },
            sort: true,
            search: true,
        }).render(document.getElementById('booking-grid'));
    });
</script>
@endpush

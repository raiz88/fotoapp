@extends('layouts.app')

@section('title', 'Booking Calendar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Booking Calendar</h4>
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
                <div id="booking-calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('velzon/assets/libs/fullcalendar/main.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('velzon/assets/libs/fullcalendar/main.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const events = @json($events);

        const calendarEl = document.getElementById('booking-calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: events,
            eventClick: function (info) {
                alert('Booking: ' + info.event.title);
            }
        });
        calendar.render();
    });
</script>
@endpush

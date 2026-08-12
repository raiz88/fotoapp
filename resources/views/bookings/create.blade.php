@extends('layouts.app')

@section('title', 'New Booking')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">New Booking</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Maklumat Booking</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Client <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                                   value="{{ old('client_name') }}" placeholder="cth: Ahmad Faiz" required>
                            @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Package</label>
                            <select name="package" class="form-select">
                                <option value="">-- Pilih Package --</option>
                                <option value="Wedding" @selected(old('package') == 'Wedding')>Wedding</option>
                                <option value="Portrait" @selected(old('package') == 'Portrait')>Portrait</option>
                                <option value="Event" @selected(old('package') == 'Event')>Event</option>
                                <option value="Pre-wedding" @selected(old('package') == 'Pre-wedding')>Pre-wedding</option>
                                <option value="Corporate" @selected(old('package') == 'Corporate')>Corporate</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="client@email.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telefon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="012-3456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tarikh Booking <span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" class="form-control @error('booking_date') is-invalid @enderror"
                                   value="{{ old('booking_date') }}" required>
                            @error('booking_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Masa</label>
                            <input type="time" name="booking_time" class="form-control" value="{{ old('booking_time') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="cth: Dewan Seri Budaya">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga (RM)</label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', 0) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                @foreach (\App\Models\Booking::STATUSES as $s)
                                    <option value="{{ $s }}" @selected(old('status', 'pending') == $s)>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nota</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Nota tambahan...">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12 text-end">
                            <a href="{{ route('bookings.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="ri-save-line align-bottom me-1"></i> Simpan Booking</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

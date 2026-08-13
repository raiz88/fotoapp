@extends('layouts.app')

@section('title', $addon->exists ? 'Edit Add-on' : 'Add-on Baharu')

@section('content')
    <h4 class="mb-4">{{ $addon->exists ? 'Edit Add-on' : 'Add-on Baharu' }}</h4>

    <form method="POST" action="{{ $addon->exists ? route('admin.addons.update', $addon) : route('admin.addons.store') }}">
        @csrf
        @if ($addon->exists) @method('PUT') @endif

        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select" required>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id', $addon->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $addon->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kod</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $addon->code) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Penerangan</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $addon->description) }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Harga (RM)</label>
                        <input type="number" step="0.01" name="price_ringgit" class="form-control" value="{{ old('price_ringgit', $addon->price_cents?->ringgit()) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unit</label>
                        <select name="unit" class="form-select">
                            @foreach (['unit', 'hour', 'pax', 'km', 'flat'] as $unit)
                                <option value="{{ $unit }}" @selected(old('unit', $addon->unit) === $unit)>{{ $unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kuantiti Min</label>
                        <input type="number" name="min_qty" class="form-control" value="{{ old('min_qty', $addon->min_qty ?? 1) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kuantiti Max</label>
                        <input type="number" name="max_qty" class="form-control" value="{{ old('max_qty', $addon->max_qty) }}">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $addon->is_active ?? true))>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.addons.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
@endsection

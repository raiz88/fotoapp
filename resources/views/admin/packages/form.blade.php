@extends('layouts.app')

@section('title', $package->exists ? 'Edit Pakej' : 'Pakej Baharu')

@section('content')
    <h4 class="mb-4">{{ $package->exists ? 'Edit Pakej' : 'Pakej Baharu' }}</h4>

    <form method="POST" action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}">
        @csrf
        @if ($package->exists) @method('PUT') @endif

        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select" required>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id', $package->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Pakej</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Slug (URL)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $package->slug) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $package->tagline) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nota Harga</label>
                        <input type="text" name="price_note" class="form-control" value="{{ old('price_note', $package->price_note) }}" placeholder="cth: harga mula dari">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Penerangan</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $package->description) }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Harga (RM)</label>
                        <input type="number" step="0.01" name="price_ringgit" class="form-control" value="{{ old('price_ringgit', $package->price_cents?->ringgit()) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Harga Asal (RM, opsyenal)</label>
                        <input type="number" step="0.01" name="was_price_ringgit" class="form-control" value="{{ old('was_price_ringgit', $package->was_price_cents?->ringgit()) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tempoh Sesi (minit)</label>
                        <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $package->duration_minutes) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Susunan Papar</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $package->sort_order) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Max Pax</label>
                        <input type="number" name="max_pax" class="form-control" value="{{ old('max_pax', $package->max_pax) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bil. Gambar Edit</label>
                        <input type="number" name="edited_photos_count" class="form-control" value="{{ old('edited_photos_count', $package->edited_photos_count) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tempoh Siap (hari)</label>
                        <input type="number" name="delivery_days" class="form-control" value="{{ old('delivery_days', $package->delivery_days) }}">
                    </div>

                    <div class="col-12 d-flex gap-4 mt-2">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $package->is_active ?? true))>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" @checked(old('is_featured', $package->is_featured))>
                            <label class="form-check-label" for="is_featured">Paling Popular</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="published_at" value="1" class="form-check-input" id="published_at" @checked(old('published_at', $package->published_at))>
                            <label class="form-check-label" for="published_at">Terbitkan (papar di website)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
@endsection

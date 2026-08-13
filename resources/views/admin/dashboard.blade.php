@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-1">Dashboard</h4>
            <p class="text-muted">Ringkasan pakej dan add-on untuk kedua-dua brand.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Jumlah Pakej</p>
                    <h4 class="mb-0">{{ $totalPackages }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Jumlah Add-on</p>
                    <h4 class="mb-0">{{ $totalAddons }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($brands as $brand)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">{{ $brand->name }}</h5>
                        <span class="badge {{ $brand->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $brand->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">{{ $brand->tagline }}</p>
                        <div class="d-flex gap-4">
                            <div>
                                <span class="fw-semibold">{{ $brand->packages_count }}</span>
                                <span class="text-muted"> pakej</span>
                            </div>
                            <div>
                                <span class="fw-semibold">{{ $brand->addons_count }}</span>
                                <span class="text-muted"> add-on</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-primary mt-3">
                            Urus Pakej
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

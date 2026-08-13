@extends('layouts.app')

@section('title', 'Pakej')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Pakej</h4>
            <p class="text-muted mb-0">Harga yang dipapar terus kat website public.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-success">
            <i class="ri-add-line align-bottom me-1"></i> Pakej Baharu
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Brand</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $package)
                        <tr>
                            <td>{{ $package->brand->name }}</td>
                            <td>
                                {{ $package->name }}
                                @if ($package->is_featured)
                                    <span class="badge bg-warning-subtle text-warning ms-1">Popular</span>
                                @endif
                            </td>
                            <td>{{ $package->price_cents->format() }}</td>
                            <td>
                                @if ($package->is_active && $package->published_at)
                                    <span class="badge bg-success-subtle text-success">Terbit</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Tersembunyi</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-soft-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="d-inline" onsubmit="return confirm('Padam pakej ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">Padam</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Tiada pakej lagi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

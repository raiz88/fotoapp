@extends('layouts.app')

@section('title', 'Add-on')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1">Add-on</h4>
            <p class="text-muted mb-0">Extra yang customer boleh tambah pada mana-mana pakej.</p>
        </div>
        <a href="{{ route('admin.addons.create') }}" class="btn btn-success">
            <i class="ri-add-line align-bottom me-1"></i> Add-on Baharu
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
                        <th>Unit</th>
                        <th>Status</th>
                        <th class="text-end">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($addons as $addon)
                        <tr>
                            <td>{{ $addon->brand->name }}</td>
                            <td>{{ $addon->name }}</td>
                            <td>{{ $addon->price_cents->format() }}</td>
                            <td>{{ $addon->unit }}</td>
                            <td>
                                @if ($addon->is_active)
                                    <span class="badge bg-success-subtle text-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.addons.edit', $addon) }}" class="btn btn-sm btn-soft-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.addons.destroy', $addon) }}" class="d-inline" onsubmit="return confirm('Padam add-on ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">Padam</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tiada add-on lagi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

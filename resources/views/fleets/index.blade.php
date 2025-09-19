@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Armada</h3>
    <a href="{{ route('fleets.create') }}" class="btn btn-primary">+ Tambah Armada</a>
</div>

{{-- 🔍 Form Filter --}}
<form method="GET" action="{{ route('fleets.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <select name="vehicle_type" class="form-select">
            <option value="">-- Semua Jenis Kendaraan --</option>
            <option value="truck" {{ request('vehicle_type') == 'truck' ? 'selected' : '' }}>Truck</option>
            <option value="van" {{ request('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
            <option value="pickup" {{ request('vehicle_type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
            {{-- Tambahkan opsi lain sesuai kebutuhan --}}
        </select>
    </div>
    <div class="col-md-3">
        <select name="availability" class="form-select">
            <option value="">-- Semua Status --</option>
            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Tersedia</option>
            <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Filter</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('fleets.index') }}" class="btn btn-outline-dark w-100">Reset</a>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No Polisi</th>
            <th>Jenis Kendaraan</th>
            <th>Kapasitas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fleets as $fleet)
        <tr>
            <td>{{ $fleet->plate_number }}</td>
            <td>{{ ucfirst($fleet->vehicle_type) }}</td>
            <td>{{ $fleet->capacity }}</td>
            <td>
                <span class="badge bg-{{ $fleet->availability == 'available' ? 'success' : 'secondary' }}">
                    {{ $fleet->availability }}
                </span>
            </td>
            <td>
                <a href="{{ route('fleets.edit', $fleet) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('fleets.destroy', $fleet) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus armada ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Belum ada data armada</td></tr>
        @endforelse
    </tbody>
</table>

{{-- supaya filter ikut di pagination --}}
{{ $fleets->appends(request()->query())->links() }}
@endsection

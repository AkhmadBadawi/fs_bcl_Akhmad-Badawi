@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Pengiriman</h2>
        <a href="{{ route('shipments.create') }}" class="btn btn-primary">+ Tambah Pengiriman</a>
    </div>

    {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('shipments.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor tracking atau tujuan..."
                value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>No. Tracking</th>
                <th>Tanggal Kirim</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Status</th>
                <th>Armada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shipments as $shipment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $shipment->tracking_number }}</td>
                    <td>{{ $shipment->shipped_at ? \Carbon\Carbon::parse($shipment->shipped_at)->format('d-m-Y') : '-' }}
                    </td>
                    <td>{{ $shipment->origin }}</td>
                    <td>{{ $shipment->destination }}</td>
                    <td>
                        <span
                            class="badge 
                        @if ($shipment->status == 'pending') bg-secondary 
                        @elseif($shipment->status == 'in_transit') bg-warning 
                        @else bg-success @endif">
                            {{ ucfirst($shipment->status) }}
                        </span>
                    </td>
                    <td>{{ $shipment->fleet?->plate_number ?? '-' }}</td>
                    <td>
                        <a href="{{ route('shipments.edit', $shipment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data pengiriman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $shipments->appends(request()->query())->links() }}
@endsection

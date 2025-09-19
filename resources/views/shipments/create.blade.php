@extends('layouts.app')

@section('title', 'Tambah Pengiriman')

@section('content')
<h2 class="mb-4">Tambah Pengiriman</h2>

<form action="{{ route('shipments.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>No. Tracking</label>
        <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number') }}" required>
        @error('tracking_number') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label>Tanggal Kirim</label>
        <input type="date" name="shipped_at" class="form-control" value="{{ old('shipped_at') }}">
    </div>

    <div class="mb-3">
        <label>Lokasi Asal</label>
        <input type="text" name="origin" class="form-control" value="{{ old('origin') }}" required>
    </div>

    <div class="mb-3">
        <label>Lokasi Tujuan</label>
        <input type="text" name="destination" class="form-control" value="{{ old('destination') }}" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_transit" {{ old('status') == 'in_transit' ? 'selected' : '' }}>In Transit</option>
            <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Detail Barang</label>
        <textarea name="details" class="form-control" rows="3">{{ old('details') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Pilih Armada</label>
        <select name="fleet_id" class="form-control">
            <option value="">-- Pilih Armada --</option>
            @foreach($fleets as $fleet)
                <option value="{{ $fleet->id }}" {{ old('fleet_id') == $fleet->id ? 'selected' : '' }}>
                    {{ $fleet->plate_number }} - {{ $fleet->vehicle_type }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

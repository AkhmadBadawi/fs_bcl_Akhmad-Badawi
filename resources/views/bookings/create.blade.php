@extends('layouts.app')

@section('title', 'Tambah Pemesanan')

@section('content')
<h2>Tambah Pemesanan</h2>

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="customer_name" class="form-label">Nama Pelanggan</label>
        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
    </div>

    <div class="mb-3">
        <label for="fleet_id" class="form-label">Armada</label>
        <select name="fleet_id" class="form-select">
            <option value="">-- Pilih Armada --</option>
            @foreach($fleets as $fleet)
                <option value="{{ $fleet->id }}" {{ old('fleet_id') == $fleet->id ? 'selected' : '' }}>
                    {{ $fleet->plate_number }} ({{ ucfirst($fleet->vehicle_type) }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="vehicle_type_requested" class="form-label">Jenis Kendaraan Diminta</label>
        <input type="text" name="vehicle_type_requested" class="form-control" value="{{ old('vehicle_type_requested') }}" required>
    </div>

    <div class="mb-3">
        <label for="booking_date" class="form-label">Tanggal Pemesanan</label>
        <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date') }}" required>
    </div>

    <div class="mb-3">
        <label for="shipment_details" class="form-label">Detail Barang</label>
        <textarea name="shipment_details" class="form-control" rows="3" required>{{ old('shipment_details') }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

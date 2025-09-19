@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Fleet: {{ $fleet->plate_number }}</h2>
    <a href="{{ route('fleets.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('fleets.update', $fleet->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="plate_number" class="form-label">Nomor Polisi</label>
                <input type="text" class="form-control @error('plate_number') is-invalid @enderror"
                    id="plate_number" name="plate_number" value="{{ old('plate_number', $fleet->plate_number) }}" required>
                @error('plate_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="vehicle_type" class="form-label">Jenis Kendaraan</label>
                <input type="text" class="form-control @error('vehicle_type') is-invalid @enderror"
                    id="vehicle_type" name="vehicle_type" value="{{ old('vehicle_type', $fleet->vehicle_type) }}" required>
                @error('vehicle_type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Kapasitas</label>
                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                    id="capacity" name="capacity" value="{{ old('capacity', $fleet->capacity) }}" required>
                @error('capacity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="availability" class="form-label">Ketersediaan</label>
                <select class="form-select @error('availability') is-invalid @enderror"
                    id="availability" name="availability">
                    <option value="available" {{ old('availability', $fleet->availability) == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="unavailable" {{ old('availability', $fleet->availability) == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('availability')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Fleet Baru</h2>
        <a href="{{ route('fleets.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('fleets.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="plate_number" class="form-label">Nomor Polisi</label>
                    <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plate_number"
                        name="plate_number" value="{{ old('plate_number') }}" required>
                    @error('plate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="vehicle_type" class="form-label">Jenis Kendaraan</label>
                    <select class="form-select @error('vehicle_type') is-invalid @enderror" 
                            id="vehicle_type" 
                            name="vehicle_type" required>
                        <option value="">-- Pilih Jenis Kendaraan --</option>
                        <option value="Truk" {{ old('vehicle_type') == 'Truk' ? 'selected' : '' }}>Truk</option>
                        <option value="Pick Up" {{ old('vehicle_type') == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                        <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="Container" {{ old('vehicle_type') == 'Container' ? 'selected' : '' }}>Container</option>
                    </select>
                    @error('vehicle_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="mb-3">
                    <label for="capacity" class="form-label">Kapasitas</label>
                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity"
                        name="capacity" value="{{ old('capacity') }}" required>
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="availability" class="form-label">Ketersediaan</label>
                    <select class="form-select @error('availability') is-invalid @enderror" id="availability"
                        name="availability">
                        <option value="available" {{ old('availability') == 'available' ? 'selected' : '' }}>Tersedia
                        </option>
                        <option value="unavailable" {{ old('availability') == 'unavailable' ? 'selected' : '' }}>Tidak
                            Tersedia</option>
                    </select>
                    @error('availability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

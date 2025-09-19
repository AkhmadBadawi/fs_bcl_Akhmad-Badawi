@extends('layouts.app')

@section('title', 'Laporan Pengiriman')

@section('content')
<div class="container">
    <h2>Laporan Pengiriman Armada</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>No Polisi</th>
                <th>Jenis Kendaraan</th>
                <th>Jumlah Pengiriman Dalam Perjalanan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report as $item)
            <tr>
                <td>{{ $item->plate_number }}</td>
                <td>{{ ucfirst($item->vehicle_type) }}</td>
                <td>{{ $item->in_transit_count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

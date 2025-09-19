@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bookings</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Create Booking</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Pelanggan</th>
                <th>Armada yang dipesan</th>
                <th>Kendaraan yang Dipesan</th>
                <th>Tanggal Pemesanan</th>
                <th>Detil Pemesanan </th>
                <th>Status Pemesanan</th>
                <th>Aksi</th>
                <th>Ubah Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                

                <td>{{ $booking->customer_name }}</td>
                <td>{{ $booking->fleet?->name ?? '-' }}</td>
                <td>{{ $booking->vehicle_type_requested }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                <td>{{ $booking->shipment_details }}</td>
                <td>
                    <span class="badge 
                        @if ($booking->status == 'pending') bg-secondary
                        @elseif($booking->status == 'confirmed') bg-success
                        @else bg-danger @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
                <!-- 🔹 Dropdown status -->
                <td>
                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select" data-current="{{ $booking->status }}" onchange="confirmStatusChange(this)">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmStatusChange(selectElement) {
            let form = selectElement.closest('form');
            let newStatus = selectElement.value;
            let currentStatus = selectElement.getAttribute('data-current') || '';
        
            if (confirm("Apakah Anda yakin ingin mengubah status menjadi '" + newStatus + "'?")) {
                form.submit();
            } else {
                // kembalikan ke status sebelumnya jika dibatalkan
                selectElement.value = currentStatus;
            }
        }
        </script>
</div>
@endsection

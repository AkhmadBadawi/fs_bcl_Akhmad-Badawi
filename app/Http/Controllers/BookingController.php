<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Fleet;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('fleet')->orderBy('created_at', 'desc')->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fleets = Fleet::where('availability', 'available')->get();
        return view('bookings.create', compact('fleets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'fleet_id' => 'nullable|exists:fleets,id',
            'vehicle_type_requested' => 'required|string|max:255',
            'booking_date' => 'required|date|after_or_equal:today',
            'shipment_details' => 'required|string',
        ]);

        $booking = Booking::create($data);

        // Jika ada armada dipilih, set jadi unavailable
        if ($booking->fleet_id) {
            $booking->fleet->update(['availability' => 'unavailable']);
        }

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $fleets = Fleet::all();
        return view('bookings.edit', compact('booking', 'fleets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'fleet_id' => 'nullable|exists:fleets,id',
            'vehicle_type_requested' => 'required|string|max:255',
            'booking_date' => 'required|date|after_or_equal:today',
            'shipment_details' => 'required|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($data);

        // Update status armada
        if ($booking->fleet_id) {
            if ($booking->status === 'cancelled') {
                $booking->fleet->update(['availability' => 'available']);
            } else {
                $booking->fleet->update(['availability' => 'unavailable']);
            }
        }

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }

    // 🔹 Update status dari dropdown di index
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('bookings.index')->with('success', 'Status updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Jika pemesanan punya armada, kembalikan ke available
        if ($booking->fleet_id) {
            $booking->fleet->update(['availability' => 'available']);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
}

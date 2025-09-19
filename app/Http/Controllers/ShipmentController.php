<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Fleet;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Shipment::with('fleet');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        $shipments = $query->orderBy('shipped_at', 'desc')->paginate(10);

        return view('shipments.index', compact('shipments'));
    }

    public function report()
{
    // Query statistik jumlah pengiriman yang sedang dalam perjalanan (in_transit) untuk setiap armada
    $report = DB::table('fleets')
        ->leftJoin('shipments', 'fleets.id', '=', 'shipments.fleet_id')
        ->select(
            'fleets.plate_number',
            'fleets.vehicle_type',
            DB::raw('COUNT(CASE WHEN shipments.status = "in_transit" THEN 1 END) as in_transit_count')
        )
        ->groupBy('fleets.id', 'fleets.plate_number', 'fleets.vehicle_type')
        ->get();

    return view('shipments.report', compact('report'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fleets = Fleet::all();
        return view('shipments.create', compact('fleets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|unique:shipments,tracking_number|max:50',
            'shipped_at'      => 'nullable|date',
            'origin'          => 'required|string|max:100',
            'destination'     => 'required|string|max:100',
            'status'          => 'required|in:pending,in_transit,delivered',
            'details'         => 'nullable|string',
            'fleet_id'        => 'nullable|exists:fleets,id',
        ]);

        Shipment::create($validated);

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return view('shipments.show', compact('shipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        $fleets = Fleet::all();
        return view('shipments.edit', compact('shipment', 'fleets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|max:50|unique:shipments,tracking_number,' . $shipment->id,
            'shipped_at'      => 'nullable|date',
            'origin'          => 'required|string|max:100',
            'destination'     => 'required|string|max:100',
            'status'          => 'required|in:pending,in_transit,delivered',
            'details'         => 'nullable|string',
            'fleet_id'        => 'nullable|exists:fleets,id',
        ]);

        $shipment->update($validated);

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Pengiriman berhasil dihapus.');
    }
}

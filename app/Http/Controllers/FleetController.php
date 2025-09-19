<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fleet::query();

        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        if ($request->filled('availability')) {
            $query->where('availability', $request->availability);
        }

        $fleets = $query->paginate(10);

        return view('fleets.index', compact('fleets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fleets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|unique:fleets,plate_number|max:50',
            'vehicle_type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'availability' => 'required|in:available,unavailable',
        ]);

        Fleet::create($validated);

        return redirect()->route('fleets.index')
            ->with('success', 'Fleet berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fleet $fleet)
    {
        return view('fleets.show', compact('fleet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fleet $fleet)
    {
        return view('fleets.edit', compact('fleet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fleet $fleet)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:50|unique:fleets,plate_number,' . $fleet->id,
            'vehicle_type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'availability' => 'required|in:available,unavailable',
        ]);

        $fleet->update($validated);

        return redirect()->route('fleets.index')
            ->with('success', 'Fleet berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fleet $fleet)
    {
        $fleet->delete();

        return redirect()->route('fleets.index')
            ->with('success', 'Fleet berhasil dihapus.');
    }
}

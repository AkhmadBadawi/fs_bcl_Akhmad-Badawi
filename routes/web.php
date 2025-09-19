<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FleetCheckinController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('fleets.index');
});

// Resource route untuk fleet CRUD
Route::resource('fleets', FleetController::class);

// Shipments (tracking)
Route::resource('shipments', ShipmentController::class);
Route::get('track', [ShipmentController::class,'trackForm'])->name('shipments.track.form');
Route::post('track', [ShipmentController::class,'track'])->name('shipments.track');
Route::get('shipments/report', [ShipmentController::class, 'report'])->name('shipments.report');

// Bookings
Route::resource('bookings', BookingController::class);
Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');


// Check-in (API endpoint for fleet to post their coords)
Route::post('fleets/{fleet}/checkin', [FleetCheckinController::class,'store'])->name('fleets.checkin.store');

// Reports
Route::get('reports/in-transit-per-fleet', [ReportController::class,'inTransitPerFleet'])->name('reports.in_transit');

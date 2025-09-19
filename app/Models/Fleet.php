<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = ['plate_number','vehicle_type','capacity','availability'];
    protected $casts = [
        'shipped_at' => 'date'
    ];

    public function shipments(){
        return $this->hasMany(Shipment::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function checkins(){
        return $this->hasMany(FleetCheckin::class);
    }
}

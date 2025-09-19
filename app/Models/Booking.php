<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['customer_name','fleet_id','vehicle_type_requested','booking_date','shipment_details','status'];

    public function fleet(){
        return $this->belongsTo(Fleet::class);
    }
}

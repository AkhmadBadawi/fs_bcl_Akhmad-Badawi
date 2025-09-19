<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['tracking_number','shipped_at','origin','destination','status','details','fleet_id'];

    public function fleet(){
        return $this->belongsTo(Fleet::class);
    }
}

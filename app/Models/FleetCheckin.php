<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetCheckin extends Model
{
    protected $fillable = ['fleet_id','latitude','longitude','recorded_at','note'];

    public function fleet(){
        return $this->belongsTo(Fleet::class);
    }
}

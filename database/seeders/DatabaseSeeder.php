<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fleet;
use App\Models\Booking;
use App\Models\Shipment;
use App\Models\FleetCheckin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(){
        Fleet::create(['plate_number'=>'B1234ABC','vehicle_type'=>'truck','capacity'=>2000,'availability'=>'available']);
        Fleet::create(['plate_number'=>'B5678DEF','vehicle_type'=>'van','capacity'=>500,'availability'=>'available']);
    }
}

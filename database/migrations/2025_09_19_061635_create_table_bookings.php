<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->foreignId('fleet_id')->nullable()->constrained('fleets')->nullOnDelete();
            $table->string('vehicle_type_requested');
            $table->date('booking_date');
            $table->text('shipment_details');
            $table->enum('status', ['pending','confirmed','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_bookings');
    }
};

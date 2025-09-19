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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->date('shipped_at')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->enum('status', ['pending','in_transit','delivered'])->default('pending');
            $table->text('details')->nullable(); // JSON or plain text
            $table->foreignId('fleet_id')->nullable()->constrained('fleets')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_shipments');
    }
};

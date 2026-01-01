<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('service_type');//, ['spa', 'room', 'bar', 'restaurant'])->default('room');
            $table->string('order_type');//, ['take_away', 'room_service', 'dining_in'])->default('room_service');
            $table->foreignId('room_table_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('bar_section')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

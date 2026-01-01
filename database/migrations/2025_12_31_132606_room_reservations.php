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
        Schema::create("room_reservations", function(Blueprint $table){
            $table->id();
            $table->string('room_id')// forign key 
            $table->string('guest_id')// forign key 
            $table->string('room_res_date'); // date
            $table->string('room_res_source'); // online, walkin, agency..
            $table->string('room_res_status'); // pending, confirmed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
           Schema::dropIfExists('room_reservations');
    
    }
};

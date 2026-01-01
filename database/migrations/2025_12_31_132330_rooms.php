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
       Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->string('room_number')->unique();
            $table->string('room_type');      // single, double
            $table->string('room_status')->index(); // available, booked, maintenance
            $table->string('room_class')->index();  // normal, vip, luxury

            $table->decimal('room_price', 10, 2);
            $table->boolean('room_is_cleaned')->default(true);

            $table->json('room_services')->nullable(); // wifi, tv, minibar
            $table->json('room_photos')->nullable();   // image paths

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
          Schema::dropIfExists('rooms');
    }
};

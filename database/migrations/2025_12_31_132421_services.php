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
        Schema::create("services", function(Blueprint $table){
            $table->id();
            $table->string('service_name')// 
            $table->string('service_class'); // spa,room,loundary..transp 
            $table->string('service_type'); // free or paid
            $table->string('service_category'); // house keep, wellness, food, transport
            $table->string('service_status'); // avaliable/ not avaliable
            $table->string('service_photo')->nullable(); // 
           $table->text('service_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('services');
    }
};

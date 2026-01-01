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
          Schema::create("guests", function(Blueprint $table){
            $table->id();
            $table->string('guest_id_type')// N id, Driver lic.. kebele.. employemet;
            $table->string('guest_id_number');

            $table->string('guest_fname');
            $table->string('guest_mname')->nullable();
            $table->string('guest_lname')->nullable();

            $table->string('guest_sex');

            $table->string('guest_phone');
            $table->string('guest_email')->nullable();

            $table->string('guest_country');
            $table->string('guest_region');
            $table->string('guest_town');

            $table->date('guest_reg_date');

            $table->string('guest_reg_by')->nullable(); // self or staff id

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};

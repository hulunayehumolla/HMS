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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('registration_number')->unique()->nullable();
            $table->string('type')->comment('e.g., General, Specialized, Clinic');
            $table->string('logo')->nullable()->comment('Path to the logo image file');
            $table->string('slogan')->nullable();
            
            // Contact Information
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('emergency_contact')->nullable();
            
            // Location Details
            $table->text('country');
            $table->string('zone');
            $table->string('woreda');
            $table->string('kebele');
            $table->string('zip_code')->nullable();
            
            // Operational Data
            $table->integer('capacity_beds')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('website')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Recommended for auditing
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('hospitals');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('patient_id')->unique();

            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name')->nullable();

            $table->enum('gender', ['male', 'female'])->index();
            $table->integer('age');
            $table->date('date_of_birth')->nullable();

            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();

            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('zone')->nullable();
            $table->string('woreda')->nullable();
            $table->string('kebele')->nullable();

            $table->string('blood_type')->nullable();

            $table->boolean('is_referred')->default(false);
            $table->boolean('is_insurance_user')->default(false);

            $table->string('referred_from')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }

};

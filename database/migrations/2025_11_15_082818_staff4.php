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
    Schema::create('staff', function (Blueprint $table) {
        $table->id(); // Primary Key
        // Optional department relationship
        $table->string('staff_id');
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        $table->string('first_name');
        $table->string('middle_name')->nullable();
        $table->string('last_name');

        $table->enum('gender', ['Male', 'Female']);
        $table->date('date_of_birth')->nullable();

        $table->string('country_name');
        $table->string('region_name');
        $table->string('zone_name')->nullable();
        $table->string('kebele_name')->nullable();

        $table->string('phone')->unique();
        $table->string('email')->unique();
        $table->text('address')->nullable();

        $table->date('hire_date')->nullable(); // fixed missing '->'
        $table->enum('employment_type', ['Permanent', 'Contract', 'Temporary']);
        $table->decimal('salary', 12, 2);

        $table->enum('status', ['Active', 'Inactive'])->default('Active');

        $table->timestamps(); // created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

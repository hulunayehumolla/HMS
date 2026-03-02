<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('patient_lab_tests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
    $table->foreignId('requested_by')->constrained('staff')->cascadeOnDelete();
    $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
    $table->text('result')->nullable();
    $table->enum('status', ['pending','completed'])->default('pending');
    $table->timestamps();
});



    }

    public function down(): void
    {
        Schema::dropIfExists('patient_lab_tests');
    }
};

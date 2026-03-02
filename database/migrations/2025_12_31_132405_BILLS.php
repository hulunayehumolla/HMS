<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('bills', function (Blueprint $table) {
    $table->id();
    $table->string('bill_number')->unique();
    $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
    $table->foreignId('appointment_id')->nullable() ->constrained()->nullOnDelete();
    $table->foreignId('admission_id')->nullable()->constrained()->nullOnDelete();
    $table->decimal('total_amount', 12, 2)->default(0);
    $table->decimal('paid_amount', 12, 2)->default(0);
    $table->enum('payment_status', ['unpaid','partial','paid'])->default('unpaid');
    $table->timestamps();
});





    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};

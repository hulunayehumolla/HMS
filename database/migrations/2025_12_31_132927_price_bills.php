<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_bills', function (Blueprint $table) {
            $table->id();
            // Foreign key
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // Quantity and pricing
            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 10, 2);
            // Payment
            $table->string('payment_status');//, ['paid', 'partial', 'unpaid'])->default('unpaid');
            // Invoice info
            $table->string('invoice_number')->unique();
            $table->date('date'); // invoice date
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_bills');
    }
};

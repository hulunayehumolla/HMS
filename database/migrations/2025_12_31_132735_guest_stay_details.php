<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_stay_details', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->foreignId('reservation_id')->constrained('room_reservations')->cascadeOnDelete();
            $table->foreignId('guest_id') ->constrained('guests')  ->cascadeOnDelete();
            // Stay Dates
            $table->date('check_in_date');
            $table->date('check_out_date');
            // Stay Details
            $table->unsignedInteger('no_of_adults')->default(1);
            $table->unsignedInteger('no_of_nights');
            // Pricing
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('advance_payment', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            // Payment
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_method')->nullable();// mobile, bank trans.. cash, card
            // Audit
            $table->string('recorded_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_stay_details');
    }
};

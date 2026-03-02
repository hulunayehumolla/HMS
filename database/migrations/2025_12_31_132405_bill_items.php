<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('bill_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('bill_id')->constrained()->cascadeOnDelete();
    $table->string('service_type'); // consultation, lab, medicine, room
    $table->unsignedBigInteger('service_id')->nullable();
    $table->string('description');
    $table->decimal('amount', 12, 2);
    $table->timestamps();
});




    }

    public function down(): void
    {
        Schema::dropIfExists('bill_items');
    }
};

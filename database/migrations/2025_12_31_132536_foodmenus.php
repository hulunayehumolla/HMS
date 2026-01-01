<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_menus', function (Blueprint $table) {
            $table->id();

            $table->string('food_name');
            $table->string('food_type');// ['fasting', 'non_fasting', 'paid'])->default('paid');
            $table->string('food_content'); // veg, meat, milk, etc.
            $table->string('food_category');// ['breakfast', 'lunch', 'snack', 'dinner'])->default('breakfast');
            $table->unsignedInteger('food_number_of_person')->default(1);
            $table->text('food_description')->nullable();
            $table->decimal('food_price', 10, 2);
            $table->string('food_photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_menus');
    }
};

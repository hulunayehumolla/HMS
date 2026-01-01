<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beverage_menus', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('class');// ['alcoholic', 'hot', 'cold', 'non_alcoholic'])->default('non_alcoholic');
            $table->string('type') ;//, ['tea', 'coffee', 'juice', 'softdrink', 'beer', 'wine'])->default('softdrink');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('recorded_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beverage_menus');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('pharmacists', function (Blueprint $table) {
        $table->id();
        $table->string('pharmacist_id'); // MUST match staff.staff_id type
        $table->string('qualification')->nullable();
        $table->string('license_number')->unique();
        $table->timestamps();

        $table->foreign('pharmacist_id')
              ->references('staff_id')
              ->on('staff') // make sure table name is EXACT
              ->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};


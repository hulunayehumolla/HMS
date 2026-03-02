<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('nurses', function (Blueprint $table) {
        $table->id();
        $table->string('nurse_id')->unique(); // MUST match staff.staff_id type
        $table->string('specialization');
        $table->string('qualification')->nullable();
        $table->string('shift_type')->nullable();
        $table->string('nursing_level')->nullable();
        $table->string('license_number')->unique();
        $table->string('ward_assigned')->unique();
        $table->timestamps();

 /*       $table->foreign('doctor_id')
              ->references('staff_id')
              ->on('staff') // make sure table name is EXACT
              ->onDelete('cascade');*/
    });
}

    public function down(): void
    {
        Schema::dropIfExists('nurses');
    }
};


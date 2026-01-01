<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->json('category'); // All, Parents, Teachers, Students, etc.
            $table->json('images')->nullable(); // Store multiple image paths as a JSON array
            $table->string('postDate'); 
            
            // Map to users.username instead of id
            $table->string('posted_by');
            $table->foreign('posted_by')->references('username')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};


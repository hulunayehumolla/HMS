<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void

    {
        //       

        Schema::create("employees", function(Blueprint $table){
            $table->id();
            $table->string('emp_Id')->unique();
            $table->string('emp_Fname');
            $table->string('emp_Mname');
            $table->string('emp_Lname');
            $table->string('emp_Sex')->nullable();
            $table->integer('emp_Phone')->nullable();
            $table->string('emp_Nationality')->nullable();
            $table->string('emp_rankId')->nullable();
            $table->string('emp_As')->nullable();// Lecturer or Tech Ass
            $table->string('emp_coll_dirId')->nullable();
            $table->string('emp_dept_teamId')->nullable();
            $table->string('emp_Status');
            $table->timestamps();
                    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

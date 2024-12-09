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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('id_number')->unique();
            $table->date('dob');
            $table->string('gender');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('specialization')->nullable();
            $table->string('academic_degree')->nullable();
            $table->date('hire_date');
            $table->boolean('status');
            $table->string('contract_type');
            $table->integer('salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};

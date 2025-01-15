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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
            $table->string('email');
            $table->date('admission_date');
            $table->year('enrollment_year');
            $table->string('enrollment_no')->unique();
            $table->string('first_last_name');
            $table->string('second_last_name')->nullable();
            $table->string('first_name');
            $table->string('place_of_birth');
            $table->date('dob');
            $table->enum('gender', ['Female', 'Male']);
            $table->string('minerd_id')->nullable();
            $table->string('nationality');
            $table->string('phone')->nullable();
            $table->string('previous_school');
            $table->string('picture_path')->nullable();
            $table->string('comments')->nullable();
            $table->enum('status', ['nuevo', 'normal','suspendido', 'retirado']);
            $table->string('document')->nullable();
            $table->boolean('is_returning')->nullable();
            $table->boolean('is_enrolled');// medical
            $table->string('activity')->nullable();
            $table->string('skill')->nullable();
            $table->string('difficulty')->nullable();
            $table->string('health_status')->nullable();
            $table->string('illness')->nullable();
            $table->string('allergies')->nullable();
            $table->string('accidents')->nullable();
            $table->string('doctor')->nullable();
            $table->string('clinic')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('vaccinations')->nullable();
            $table->string('blood_type')->nullable();//
            $table->enum('ncf_type', ['consumidor final', 'credito fiscal','regimen especial', 'gubernamental'])->nullable();
            $table->string('rnc')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

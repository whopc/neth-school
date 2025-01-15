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
        Schema::create('progenitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('first_last_name');
            $table->string('second_last_name')->nullable();
            $table->enum('id_type', [ 'national_id', 'passport']); // Ajustado
            $table->string('id_number')->unique(); // Ajustado
            $table->string('email')->nullable(); // Ajustado
            $table->string('address')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('place_of_work')->nullable();
            $table->string('work_phone')->nullable();
            $table->enum('role', ['father', 'mother']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progenitors');
    }
};

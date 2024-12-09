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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('father_id')->nullable()->constrained('progenitors')->onDelete('cascade');
            $table->foreignId('mother_id')->constrained('progenitors')->onDelete('cascade');
            $table->string('last_name');
            $table->boolean('is_separated_parents')->default(false);
            $table->boolean('no_father_data')->default(false);
            $table->boolean('tutor_enabled')->default(false);
            $table->string('t_name')->nullable();
            $table->string('t_last_name')->nullable();
            $table->string('t_address')->nullable();
            $table->string('t_telephone')->nullable();
            $table->string('kinship')->nullable();
            $table->unique(['father_id', 'mother_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};

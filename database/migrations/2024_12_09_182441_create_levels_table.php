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
        Schema::create('levels', /**
         * Create a new table schema in the database.
         * This function defines the blueprint for the table structure.
         *
         * @param Blueprint $table The table schema definition instance.
         *
         * @property int $id The primary key for the table.
         * @property string $name The name field of the table.
         * @property int|null $order The order field for sorting, nullable.
         * @property \Illuminate\Support\Carbon|null $created_at The timestamp when the record was created.
         * @property \Illuminate\Support\Carbon|null $updated_at The timestamp when the record was last updated.
         */ function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};

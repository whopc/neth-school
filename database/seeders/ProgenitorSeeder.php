<?php

namespace Database\Seeders;

use App\Models\Progenitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgenitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 fathers
        for ($i = 0; $i < 10; $i++) {
            Progenitor::factory()->father()->create();
        }

        // Crear 10 mothers
        for ($i = 0; $i < 10; $i++) {
            Progenitor::factory()->mother()->create();
        }
    }
}

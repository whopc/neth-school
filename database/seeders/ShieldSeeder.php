<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ejecuta shield:generate para todos los permisos
        Artisan::call('shield:generate --all');

        // Crea el usuario superadmin
        Artisan::call('shield:super-admin');
    }
}

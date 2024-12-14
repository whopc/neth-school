<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Aristofaneth',
            'email' => 'admin@admin.com',

        ]);
        $this->call(GradesTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(AcademicYearsTableSeeder::class);
        $this->call(AcademicLevelsTableSeeder::class);
        $this->call(AcademicGradesTableSeeder::class);
        $this->call(GradeSectionsTableSeeder::class);
        $this->call(ProgenitorsTableSeeder::class);
        $this->call(FamiliesTableSeeder::class);
        $this->call(AcademicLevelsTableSeeder::class);

    }
}

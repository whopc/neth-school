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

        \DB::table('types')->delete();

        \DB::table('types')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'ADMIN',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'TEACHER',

                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'STUDENT',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'FAMILY',
                ),
                ));

        User::factory()->create([
            'type_id' => 1,
            'name' => 'Administrador',
            'email' => 'admin@admin.com',

        ]);
        //$this->call(ShieldSeeder::class);
        $this->call(AcademicYearsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(ClassSectionsTableSeeder::class);


//        $this->call(GradesTableSeeder::class);
//        $this->call(LevelsTableSeeder::class);
//        $this->call(TeachersTableSeeder::class);
//        $this->call(ClassSectionsTableSeeder::class);
//        $this->call(AcademicYearsTableSeeder::class);
//        $this->call(AcademicLevelsTableSeeder::class);
//        $this->call(AcademicGradesTableSeeder::class);
//        $this->call(GradeSectionsTableSeeder::class);
//        $this->call(ProgenitorsTableSeeder::class);
//        $this->call(FamiliesTableSeeder::class);
//        $this->call(AcademicLevelsTableSeeder::class);

    }
}

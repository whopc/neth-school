<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicLevelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('academic_levels')->delete();
        
        \DB::table('academic_levels')->insert(array (
            0 => 
            array (
                'id' => 1,
                'academic_year_id' => 1,
                'level_id' => 1,
                'admission_fees' => '7000.00',
                'materials_fees' => NULL,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 22:41:50',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_year_id' => 1,
                'level_id' => 2,
                'admission_fees' => '8000.00',
                'materials_fees' => '3500.00',
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_year_id' => 2,
                'level_id' => 1,
                'admission_fees' => '7000.00',
                'materials_fees' => '3500.00',
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
        ));
        
        
    }
}
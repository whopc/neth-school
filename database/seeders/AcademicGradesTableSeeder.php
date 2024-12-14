<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicGradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('academic_grades')->delete();
        
        \DB::table('academic_grades')->insert(array (
            0 => 
            array (
                'id' => 1,
                'academic_level_id' => 1,
                'grade_id' => 2,
                'fee_cuota' => 35,
                'platform' => 0,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 23:04:22',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_level_id' => 1,
                'grade_id' => 1,
                'fee_cuota' => 35,
                'platform' => 0,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 23:04:22',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_level_id' => 1,
                'grade_id' => 3,
                'fee_cuota' => 45,
                'platform' => 0,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 23:04:22',
            ),
            3 => 
            array (
                'id' => 4,
                'academic_level_id' => 2,
                'grade_id' => 4,
                'fee_cuota' => 45,
                'platform' => 0,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 23:04:22',
            ),
            4 => 
            array (
                'id' => 5,
                'academic_level_id' => 3,
                'grade_id' => 2,
                'fee_cuota' => 500,
                'platform' => 1,
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
            5 => 
            array (
                'id' => 6,
                'academic_level_id' => 3,
                'grade_id' => 4,
                'fee_cuota' => 1000,
                'platform' => 1,
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
        ));
        
        
    }
}
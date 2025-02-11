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
                'grade_id' => 1,
                'fee_cuota' => 5600,
                'platform' => 0,
                'created_at' => '2025-02-06 14:44:39',
                'updated_at' => '2025-02-06 14:48:03',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_level_id' => 1,
                'grade_id' => 2,
                'fee_cuota' => 5600,
                'platform' => 0,
                'created_at' => '2025-02-06 14:45:21',
                'updated_at' => '2025-02-06 14:48:03',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_level_id' => 1,
                'grade_id' => 3,
                'fee_cuota' => 5600,
                'platform' => 0,
                'created_at' => '2025-02-06 14:45:21',
                'updated_at' => '2025-02-06 14:48:03',
            ),
            3 => 
            array (
                'id' => 4,
                'academic_level_id' => 2,
                'grade_id' => 4,
                'fee_cuota' => 6200,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            4 => 
            array (
                'id' => 5,
                'academic_level_id' => 2,
                'grade_id' => 5,
                'fee_cuota' => 6200,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            5 => 
            array (
                'id' => 6,
                'academic_level_id' => 2,
                'grade_id' => 6,
                'fee_cuota' => 6500,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            6 => 
            array (
                'id' => 7,
                'academic_level_id' => 2,
                'grade_id' => 7,
                'fee_cuota' => 6500,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            7 => 
            array (
                'id' => 8,
                'academic_level_id' => 2,
                'grade_id' => 8,
                'fee_cuota' => 6900,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            8 => 
            array (
                'id' => 9,
                'academic_level_id' => 2,
                'grade_id' => 9,
                'fee_cuota' => 6900,
                'platform' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
        ));
        
        
    }
}
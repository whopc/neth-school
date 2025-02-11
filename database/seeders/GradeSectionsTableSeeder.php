<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradeSectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grade_sections')->delete();
        
        \DB::table('grade_sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'academic_grade_id' => 1,
                'section_id' => 1,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:44:39',
                'updated_at' => '2025-02-06 14:44:39',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_grade_id' => 2,
                'section_id' => 2,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:45:21',
                'updated_at' => '2025-02-06 14:45:21',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_grade_id' => 3,
                'section_id' => 3,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:45:21',
                'updated_at' => '2025-02-06 14:45:21',
            ),
            3 => 
            array (
                'id' => 4,
                'academic_grade_id' => 4,
                'section_id' => 4,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            4 => 
            array (
                'id' => 5,
                'academic_grade_id' => 5,
                'section_id' => 5,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            5 => 
            array (
                'id' => 6,
                'academic_grade_id' => 6,
                'section_id' => 6,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            6 => 
            array (
                'id' => 7,
                'academic_grade_id' => 7,
                'section_id' => 7,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            7 => 
            array (
                'id' => 8,
                'academic_grade_id' => 8,
                'section_id' => 8,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
            8 => 
            array (
                'id' => 9,
                'academic_grade_id' => 9,
                'section_id' => 9,
                'main_teacher_id' => NULL,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
        ));
        
        
    }
}
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
                'section_id' => 2,
                'main_teacher_id' => 17,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_grade_id' => 2,
                'section_id' => 1,
                'main_teacher_id' => 3,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            2 => 
            array (
                'id' => 3,
                'academic_grade_id' => 3,
                'section_id' => 3,
                'main_teacher_id' => 7,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            3 => 
            array (
                'id' => 4,
                'academic_grade_id' => 4,
                'section_id' => 4,
                'main_teacher_id' => 12,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            4 => 
            array (
                'id' => 5,
                'academic_grade_id' => 4,
                'section_id' => 5,
                'main_teacher_id' => 13,
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            5 => 
            array (
                'id' => 6,
                'academic_grade_id' => 5,
                'section_id' => 2,
                'main_teacher_id' => 17,
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
            6 => 
            array (
                'id' => 7,
                'academic_grade_id' => 6,
                'section_id' => 4,
                'main_teacher_id' => 12,
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
            7 => 
            array (
                'id' => 8,
                'academic_grade_id' => 6,
                'section_id' => 5,
                'main_teacher_id' => 17,
                'created_at' => '2024-12-09 21:12:05',
                'updated_at' => '2024-12-09 21:12:05',
            ),
        ));
        
        
    }
}
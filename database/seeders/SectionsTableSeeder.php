<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Yellow',
                'grade_id' => 1,
                'created_at' => '2024-12-09 20:45:07',
                'updated_at' => '2024-12-09 20:45:07',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Blue',
                'grade_id' => 2,
                'created_at' => '2024-12-09 20:45:11',
                'updated_at' => '2024-12-09 20:45:11',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'white',
                'grade_id' => 3,
                'created_at' => '2024-12-09 20:45:18',
                'updated_at' => '2024-12-09 20:45:18',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Colon',
                'grade_id' => 4,
                'created_at' => '2024-12-09 20:45:25',
                'updated_at' => '2024-12-09 20:45:25',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Duarte',
                'grade_id' => 4,
                'created_at' => '2024-12-09 20:45:32',
                'updated_at' => '2024-12-09 20:45:32',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Pedro mir',
                'grade_id' => 5,
                'created_at' => '2024-12-09 20:45:39',
                'updated_at' => '2024-12-09 20:45:39',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Platon22',
                'grade_id' => 5,
                'created_at' => '2024-12-09 20:45:47',
                'updated_at' => '2024-12-09 22:50:58',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Norberto',
                'grade_id' => 5,
                'created_at' => '2024-12-09 22:47:11',
                'updated_at' => '2024-12-09 22:47:11',
            ),
        ));
        
        
    }
}
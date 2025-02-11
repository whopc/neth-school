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
                'name' => 'GREEN',
                'short_name' => 'G',
                'grade_id' => 1,
                'created_at' => '2025-01-16 15:22:34',
                'updated_at' => '2025-01-16 15:22:34',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'YELLOW',
                'short_name' => 'Y',
                'grade_id' => 2,
                'created_at' => '2025-01-16 15:22:47',
                'updated_at' => '2025-01-18 18:16:01',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'BLUE',
                'short_name' => 'B',
                'grade_id' => 3,
                'created_at' => '2025-01-16 15:23:03',
                'updated_at' => '2025-01-16 15:23:03',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'CONCEPCIÓN BONA',
                'short_name' => 'CB',
                'grade_id' => 4,
                'created_at' => '2025-01-16 15:23:26',
                'updated_at' => '2025-01-16 15:23:26',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'RAMÓN MATÍAS MELLA',
                'short_name' => 'RMM',
                'grade_id' => 5,
                'created_at' => '2025-01-16 15:24:23',
                'updated_at' => '2025-01-16 15:24:23',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'FRANCISCO DEL ROSARIO SÁNCHEZ',
                'short_name' => 'FRS',
                'grade_id' => 6,
                'created_at' => '2025-01-16 15:25:25',
                'updated_at' => '2025-01-16 15:25:25',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'MINERVA MIRABAL',
                'short_name' => 'MM',
                'grade_id' => 7,
                'created_at' => '2025-01-16 15:25:51',
                'updated_at' => '2025-01-16 15:25:51',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'MÁXIMO GÓMEZ',
                'short_name' => 'MG',
                'grade_id' => 8,
                'created_at' => '2025-01-16 15:26:23',
                'updated_at' => '2025-01-16 15:26:23',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'PEDRO MIR',
                'short_name' => 'PM',
                'grade_id' => 9,
                'created_at' => '2025-01-16 15:26:44',
                'updated_at' => '2025-01-16 15:26:44',
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AcademicYearsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('academic_years')->delete();
        
        \DB::table('academic_years')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '2024-2025',
                'short_name' => '24-25',
                'start_date' => '2024-12-10',
                'end_date' => '2025-01-10',
                'created_at' => '2024-12-09 20:48:20',
                'updated_at' => '2024-12-09 20:48:20',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '2025-2026',
                'short_name' => '25-26',
                'start_date' => '2024-12-17',
                'end_date' => '2025-01-11',
                'created_at' => '2024-12-09 21:12:04',
                'updated_at' => '2024-12-09 21:12:04',
            ),
        ));
        
        
    }
}
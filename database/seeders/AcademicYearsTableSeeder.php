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
                'start_date' => '2024-08-01',
                'end_date' => '2025-06-30',
                'status' => 1,
                'created_at' => '2025-02-06 14:36:09',
                'updated_at' => '2025-02-06 14:48:05',
            ),
        ));
        
        
    }
}
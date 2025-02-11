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
                'admission_fees' => '6000.00',
                'materials_fees' => '7000.00',
                'cuota' => 1,
                'created_at' => '2025-02-06 14:44:39',
                'updated_at' => '2025-02-06 14:44:39',
            ),
            1 => 
            array (
                'id' => 2,
                'academic_year_id' => 1,
                'level_id' => 2,
                'admission_fees' => '6800.00',
                'materials_fees' => NULL,
                'cuota' => 1,
                'created_at' => '2025-02-06 14:48:04',
                'updated_at' => '2025-02-06 14:48:04',
            ),
        ));
        
        
    }
}
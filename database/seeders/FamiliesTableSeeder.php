<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FamiliesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('families')->delete();
        
        \DB::table('families')->insert(array (
            0 => 
            array (
                'id' => 1,
                'father_id' => 1,
                'mother_id' => 2,
                'last_name' => 'CEFODIPF MINERD',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 0,
                't_name' => NULL,
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2025-01-16 13:42:50',
                'updated_at' => '2025-01-16 13:42:50',
            ),
            1 => 
            array (
                'id' => 2,
                'father_id' => 3,
                'mother_id' => 4,
                'last_name' => 'MATIAS SANCHEZ',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 0,
                't_name' => NULL,
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2025-02-06 14:53:45',
                'updated_at' => '2025-02-06 14:53:45',
            ),
        ));
        
        
    }
}
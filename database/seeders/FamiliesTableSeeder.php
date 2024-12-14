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
                'father_id' => 3,
                'mother_id' => 13,
                'last_name' => 'Haag Romaguera',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 1,
                't_name' => 'F',
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-12-09 20:49:50',
                'updated_at' => '2024-12-09 21:01:53',
            ),
            1 => 
            array (
                'id' => 2,
                'father_id' => 1,
                'mother_id' => 11,
                'last_name' => 'Rippin Kohler',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 0,
                't_name' => NULL,
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-12-09 21:00:08',
                'updated_at' => '2024-12-09 21:00:08',
            ),
            2 => 
            array (
                'id' => 3,
                'father_id' => 2,
                'mother_id' => 20,
                'last_name' => 'Hill Osinski',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 0,
                't_name' => NULL,
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-12-09 21:02:08',
                'updated_at' => '2024-12-09 21:02:08',
            ),
            3 => 
            array (
                'id' => 4,
                'father_id' => 1,
                'mother_id' => 13,
                'last_name' => 'Rippin Romaguera',
                'is_separated_parents' => 0,
                'no_father_data' => 0,
                'tutor_enabled' => 1,
                't_name' => 'GFGG',
                't_last_name' => NULL,
                't_address' => NULL,
                't_telephone' => NULL,
                'kinship' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2024-12-09 21:08:07',
                'updated_at' => '2024-12-09 21:08:07',
            ),
        ));
        
        
    }
}
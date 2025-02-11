<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProgenitorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('progenitors')->delete();
        
        \DB::table('progenitors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'PADRE',
                'first_last_name' => 'CEFODIPF',
                'second_last_name' => NULL,
                'id_type' => 'national_id',
                'id_number' => '000-0000000-0',
                'email' => NULL,
                'address' => NULL,
            'home_phone' => '(809) 573-0051',
                'mobile_phone' => NULL,
                'place_of_work' => NULL,
                'work_phone' => NULL,
                'role' => 'father',
                'created_at' => '2025-01-16 13:42:23',
                'updated_at' => '2025-01-16 13:42:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'MADRE',
                'first_last_name' => 'MINERD',
                'second_last_name' => NULL,
                'id_type' => 'national_id',
                'id_number' => '111-1111111-1',
                'email' => NULL,
                'address' => NULL,
                'home_phone' => NULL,
                'mobile_phone' => NULL,
                'place_of_work' => NULL,
                'work_phone' => NULL,
                'role' => 'mother',
                'created_at' => '2025-01-16 13:42:47',
                'updated_at' => '2025-01-16 13:42:47',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'RAFAEL ENRIQUE',
                'first_last_name' => 'MATIAS',
                'second_last_name' => 'RODRIGUEZ',
                'id_type' => 'national_id',
                'id_number' => '047-0100767-8',
                'email' => NULL,
                'address' => 'LAS MARAS, VILLA PARAISO CALLE 2',
            'home_phone' => '(829) 852-9209',
                'mobile_phone' => NULL,
                'place_of_work' => NULL,
                'work_phone' => NULL,
                'role' => 'father',
                'created_at' => '2025-02-06 14:52:23',
                'updated_at' => '2025-02-06 14:52:23',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'YUDELKA CARIDAD',
                'first_last_name' => 'SANCHEZ',
                'second_last_name' => 'HERNANDEZ',
                'id_type' => 'national_id',
                'id_number' => '047-0128634-8',
                'email' => 'YUDITHMATIAS@HOTMAIL.COM',
                'address' => 'LAS MARAS, VILLA PARAISO CALLE 2',
                'home_phone' => '8296288028',
                'mobile_phone' => NULL,
                'place_of_work' => NULL,
                'work_phone' => NULL,
                'role' => 'mother',
                'created_at' => '2025-02-06 14:53:39',
                'updated_at' => '2025-02-06 14:53:39',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
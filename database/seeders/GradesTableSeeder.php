<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grades')->delete();
        
        \DB::table('grades')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'PRE-KINDER',
                'order' => 1,
                'created_at' => '2025-01-16 15:02:51',
                'updated_at' => '2025-01-16 15:02:51',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'KINDER',
                'order' => 2,
                'created_at' => '2025-01-16 15:02:59',
                'updated_at' => '2025-01-16 15:02:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'PRE-PRIMERIO',
                'order' => 3,
                'created_at' => '2025-01-16 15:03:12',
                'updated_at' => '2025-01-16 15:03:12',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '1ERO',
                'order' => 4,
                'created_at' => '2025-01-16 15:04:06',
                'updated_at' => '2025-01-16 15:04:06',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '2DO',
                'order' => 5,
                'created_at' => '2025-01-16 15:04:14',
                'updated_at' => '2025-01-16 15:04:14',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '3ERO',
                'order' => 6,
                'created_at' => '2025-01-16 15:04:27',
                'updated_at' => '2025-01-16 15:04:27',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '4TO',
                'order' => 7,
                'created_at' => '2025-01-16 15:04:37',
                'updated_at' => '2025-01-16 15:04:37',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '5TO',
                'order' => 8,
                'created_at' => '2025-01-16 15:04:48',
                'updated_at' => '2025-01-16 15:04:48',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '6TO',
                'order' => 9,
                'created_at' => '2025-01-16 15:05:05',
                'updated_at' => '2025-01-16 15:05:05',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '1-ERO',
                'order' => 10,
                'created_at' => '2025-01-16 15:05:29',
                'updated_at' => '2025-01-16 15:05:29',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => '2-DO',
                'order' => 11,
                'created_at' => '2025-01-16 15:05:38',
                'updated_at' => '2025-01-16 15:05:38',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => '3-ERO',
                'order' => 12,
                'created_at' => '2025-01-16 15:07:13',
                'updated_at' => '2025-01-16 15:07:13',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => '4-TO',
                'order' => 13,
                'created_at' => '2025-01-16 15:07:25',
                'updated_at' => '2025-01-16 15:07:25',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '5-TO',
                'order' => 14,
                'created_at' => '2025-01-16 15:07:50',
                'updated_at' => '2025-01-16 15:07:50',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => '6-TO',
                'order' => 15,
                'created_at' => '2025-01-16 15:07:58',
                'updated_at' => '2025-01-16 15:07:58',
            ),
        ));
        
        
    }
}
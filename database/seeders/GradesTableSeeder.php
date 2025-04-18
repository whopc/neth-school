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
                'level_id' => 1,
                'name' => 'PRE-KINDER',
                'order' => 1,
                'created_at' => '2025-01-16 15:02:51',
                'updated_at' => '2025-01-16 15:02:51',
            ),
            1 =>
            array (
                'id' => 2,
                'level_id' => 1,
                'name' => 'KINDER',
                'order' => 2,
                'created_at' => '2025-01-16 15:02:59',
                'updated_at' => '2025-01-16 15:02:59',
            ),
            2 =>
            array (
                'id' => 3,
                'level_id' => 1,
                'name' => 'PRE-PRIMERIO',
                'order' => 3,
                'created_at' => '2025-01-16 15:03:12',
                'updated_at' => '2025-01-16 15:03:12',
            ),
            3 =>
            array (
                'id' => 4,
                'level_id' => 2,
                'name' => '1ERO',
                'order' => 4,
                'created_at' => '2025-01-16 15:04:06',
                'updated_at' => '2025-01-16 15:04:06',
            ),
            4 =>
            array (
                'id' => 5,
                'level_id' => 2,
                'name' => '2DO',
                'order' => 5,
                'created_at' => '2025-01-16 15:04:14',
                'updated_at' => '2025-01-16 15:04:14',
            ),
            5 =>
            array (
                'id' => 6,
                'level_id' => 2,
                'name' => '3ERO',
                'order' => 6,
                'created_at' => '2025-01-16 15:04:27',
                'updated_at' => '2025-01-16 15:04:27',
            ),
            6 =>
            array (
                'id' => 7,
                'level_id' => 2,
                'name' => '4TO',
                'order' => 7,
                'created_at' => '2025-01-16 15:04:37',
                'updated_at' => '2025-01-16 15:04:37',
            ),
            7 =>
            array (
                'id' => 8,
                'level_id' => 2,
                'name' => '5TO',
                'order' => 8,
                'created_at' => '2025-01-16 15:04:48',
                'updated_at' => '2025-01-16 15:04:48',
            ),
            8 =>
            array (
                'id' => 9,
                'level_id' => 2,
                'name' => '6TO',
                'order' => 9,
                'created_at' => '2025-01-16 15:05:05',
                'updated_at' => '2025-01-16 15:05:05',
            ),
            9 =>
                array (
                    'id' => 10,
                    'level_id' => 2,
                    'name' => '7-MO',
                    'order' => 10,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            10 =>
                array (
                    'id' => 11,
                    'level_id' => 3,
                    'name' => '1-RO',
                    'order' => 10,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            11 =>
                array (
                    'id' => 12,
                    'level_id' => 2,
                    'name' => '8-VO',
                    'order' => 11,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            12 =>
                array (
                    'id' => 13,
                    'level_id' => 3,
                    'name' => '2-DO',
                    'order' => 11,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            13 =>
                array (
                    'id' => 14,
                    'level_id' => 3,
                    'name' => '1RO-B',
                    'order' => 12,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            14 =>
                array (
                    'id' => 15,
                    'level_id' => 3,
                    'name' => '3-RO',
                    'order' => 12,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            15 =>
                array (
                    'id' => 16,
                    'level_id' => 3,
                    'name' => '2DO-B',
                    'order' => 13,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            16 =>
                array (
                    'id' => 17,
                    'level_id' => 3,
                    'name' => '4-TO',
                    'order' => 13,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            17 =>
                array (
                    'id' => 18,
                    'level_id' => 3,
                    'name' => '3RO-B',
                    'order' => 14,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            18 =>
                array (
                    'id' => 19,
                    'level_id' => 3,
                    'name' => '5-TO',
                    'order' => 14,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            19 =>
                array (
                    'id' => 20,
                    'level_id' => 3,
                    'name' => '4TO-B',
                    'order' => 15,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
            20 =>
                array (
                    'id' => 21,
                    'level_id' => 3,
                    'name' => '6-TO',
                    'order' => 15,
                    'created_at' => '2025-01-16 15:07:58',
                    'updated_at' => '2025-01-16 15:07:58',
                ),
        ));


    }
}

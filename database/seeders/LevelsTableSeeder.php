<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('levels')->delete();

        \DB::table('levels')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Inical',
                'order' => 1,
                'created_at' => '2024-12-09 20:43:06',
                'updated_at' => '2024-12-09 20:43:06',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Primaria',
                'order' => 2,
                'created_at' => '2024-12-09 20:43:12',
                'updated_at' => '2024-12-09 23:03:17',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Secuandaria',
                'order' => 3,
                'created_at' => '2024-12-09 20:43:17',
                'updated_at' => '2024-12-09 20:43:17',
            ),
        ));


    }
}

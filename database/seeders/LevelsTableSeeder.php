<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'INICIAL',
                'order' => 1,
                'created_at' => '2025-01-16 15:00:42',
                'updated_at' => '2025-01-16 15:00:42',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'PRIMARIA',
                'order' => 2,
                'created_at' => '2025-01-16 15:00:53',
                'updated_at' => '2025-01-16 15:00:53',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'SECUNDARIA',
                'order' => 3,
                'created_at' => '2025-01-16 15:01:43',
                'updated_at' => '2025-01-16 15:01:43',
            ),
        ));


    }
}

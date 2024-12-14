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

        \DB::table('grades')->insert(array(
            array(
                'id' => 1,
                'name' => 'Pre-Kínder',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 2,
                'name' => 'Kínder',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 3,
                'name' => 'Pre-Primario',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 4,
                'name' => 'Primero de Primaria',
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 5,
                'name' => 'Segundo de Primaria',
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 6,
                'name' => 'Tercero de Primaria',
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 7,
                'name' => 'Cuarto de Primaria',
                'order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 8,
                'name' => 'Quinto de Primaria',
                'order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 9,
                'name' => 'Sexto de Primaria',
                'order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 10,
                'name' => 'Primero de Secundaria',
                'order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 11,
                'name' => 'Segundo de Secundaria',
                'order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 12,
                'name' => 'Tercero de Secundaria',
                'order' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 13,
                'name' => 'Cuarto de Secundaria',
                'order' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 14,
                'name' => 'Quinto de Secundaria',
                'order' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 15,
                'name' => 'Sexto de Secundaria',
                'order' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ),

        ));
    }
}


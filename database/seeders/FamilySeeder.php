<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Progenitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    public function run()
    {
        $mothers = Progenitor::where('role', 'mother')->pluck('id')->toArray();
        $fathers = Progenitor::where('role', 'father')->pluck('id')->toArray();

        // Garantizar que existan fathers y mothers suficientes
        if (empty($mothers) || empty($fathers)) {
            throw new \Exception("Debe haber al menos un father y una mother en la base de datos.");
        }

        // Crear combinaciones únicas de familias
        foreach ($mothers as $motherId) {
            foreach ($fathers as $fatherId) {
                // Crear una familia única por combinación de mother y father
                Family::factory()->create([
                    'father_id' => $fatherId,
                    'mother_id' => $motherId,
                ]);
            }
        }
    }
}

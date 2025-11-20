<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\WineyardRow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winerows = WineyardRow::all();

        if ($winerows->isEmpty()) {
            echo "Žiadne vinohradové riadky, preskakujem ošetrenia\n";
            return;
        }

        $treatments = [
            [
                'wine_row' => 1,
                'user' => 'pracovnik1',
                'date_time' => now()->subDays(60),
                'type' => 'Postrek',
                'treatment_product' => 'Kuprikol',
                'concentration' => 0.5,
                'notes' => 'Preventívne proti plesni',
            ],
            [
                'wine_row' => 1,
                'user' => 'pracovnik1',
                'date_time' => now()->subDays(45),
                'type' => 'Hnojenie',
                'treatment_product' => 'NPK hnojivo',
                'concentration' => 1.2,
                'notes' => 'Jarne prihojenie',
            ],
            [
                'wine_row' => 2,
                'user' => 'pracovnik1',
                'date_time' => now()->subDays(30),
                'type' => 'Rez',
                'treatment_product' => null,
                'concentration' => null,
                'notes' => 'Letný rez',
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }

        echo "✓ Vytvorených " . count($treatments) . " ošetrení\n";
    }
}

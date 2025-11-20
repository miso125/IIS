<?php

namespace Database\Seeders;

use App\Models\Harvest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HarvestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $harvests = [
            [
                'wine_row' => 1,
                'user' => 'vinar1',
                'weight_grapes' => 350,
                'variety' => 'Veltlínske zelené',
                'sugariness' => 18,
                'date_time' => now()->subDays(20),
            ],
            [
                'wine_row' => 2,
                'user' => 'vinar1',
                'weight_grapes' => 220,
                'variety' => 'Frankovka modrá',
                'sugariness' => 20,
                'date_time' => now()->subDays(18),
            ],
            [
                'wine_row' => 3,
                'user' => 'vinar1',
                'weight_grapes' => 400,
                'variety' => 'Riesling',
                'sugariness' => 19,
                'date_time' => now()->subDays(15),
            ],
        ];

        foreach ($harvests as $harvest) {
            Harvest::create($harvest);
        }

        echo "✓ Vytvorených " . count($harvests) . " sklizní\n";
    }
}

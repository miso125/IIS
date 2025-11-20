<?php

namespace Database\Seeders;

use App\Models\WineyardRow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WineyardRowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winerows = [
            [
                'user' => 'vinar1',
                'variety' => 'Veltlínske zelené',
                'number_of_vines' => 120,
                'planting_year' => 2015,
                'colour' => 'biela',
            ],
            [
                'user' => 'vinar1',
                'variety' => 'Frankovka modrá',
                'number_of_vines' => 80,
                'planting_year' => 2018,
                'colour' => 'červená',
            ],
            [
                'user' => 'vinar1',
                'variety' => 'Riesling',
                'number_of_vines' => 100,
                'planting_year' => 2012,
                'colour' => 'biela',
            ],
            [
                'user' => 'vinar1',
                'variety' => 'Alibernet',
                'number_of_vines' => 60,
                'planting_year' => 2020,
                'colour' => 'červená',
            ],
        ];

        foreach ($winerows as $winerow) {
            WineyardRow::create($winerow);
        }

        echo "✓ Vytvorených " . count($winerows) . " vinohradových riadkov\n";
    }
}

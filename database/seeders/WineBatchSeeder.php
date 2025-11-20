<?php

namespace Database\Seeders;

use App\Models\WineBatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WineBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = [
            [
                'harvest' => 1,
                'vintage' => 2024,
                'variety' => 'Veltlínske zelené',
                'sugariness' => 18,
                'alcohol_percentage' => 12.5,
                'number_of_bottles' => 450,
                'date_time' => now()->subDays(10),
            ],
            [
                'harvest' => 2,
                'vintage' => 2024,
                'variety' => 'Frankovka modrá',
                'sugariness' => 20,
                'alcohol_percentage' => 13.0,
                'number_of_bottles' => 300,
                'date_time' => now()->subDays(8),
            ],
            [
                'harvest' => 3,
                'vintage' => 2024,
                'variety' => 'Riesling',
                'sugariness' => 19,
                'alcohol_percentage' => 12.8,
                'number_of_bottles' => 520,
                'date_time' => now()->subDays(5),
            ],
        ];

        foreach ($batches as $batch) {
            WineBatch::create($batch);
        }

        echo "✓ Vytvorených " . count($batches) . " dávok vína\n";
    }
}

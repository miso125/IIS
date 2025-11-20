<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vytvorenie nákupu 1
        $purchase1 = Purchase::create([
            'user' => 'zakaznik1',
            'date_time' => now()->subDays(3),
            'sum' => 45.00,
        ]);

        // Položky prvého nákupu
        PurchaseItem::create([
            'purchase' => $purchase1->id_purchase,
            'wine_batch' => 1,
            'number_of_bottles' => 3,
            'stock' => true,
            'item_price' => 15.00,
        ]);

        // Vytvorenie nákupu 2
        $purchase2 = Purchase::create([
            'user' => 'zakaznik2',
            'date_time' => now()->subDays(1),
            'sum' => 96.00,
        ]);

        // Položky druhého nákupu
        PurchaseItem::create([
            'purchase' => $purchase2->id_purchase,
            'wine_batch' => 1,
            'number_of_bottles' => 2,
            'stock' => true,
            'item_price' => 15.00,
        ]);

        PurchaseItem::create([
            'purchase' => $purchase2->id_purchase,
            'wine_batch' => 3,
            'number_of_bottles' => 4,
            'stock' => true,
            'item_price' => 16.50,
        ]);

        echo "✓ Vytvorené 2 nákupy s položkami\n";
    }
}

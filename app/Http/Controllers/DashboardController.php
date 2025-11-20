<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Simulované dáta z databázy (namiesto modelu Row::all())
        $rows = [
            [
                'id' => 'R-01',
                'variety' => 'Frankovka Modrá',
                'count' => 120,
                'last_treatment_date' => Carbon::now()->subDays(20), // Pred 20 dňami (OK)
                'last_treatment_type' => 'Postrek - Síra',
                'planned_harvest' => Carbon::now()->addDays(5),
                'status' => 'ok'
            ],
            [
                'id' => 'R-02',
                'variety' => 'Rizling Vlašský',
                'count' => 115,
                'last_treatment_date' => Carbon::now()->subDays(5), // Pred 5 dňami (POZOR!)
                'last_treatment_type' => 'Postrek - Fungicíd',
                'planned_harvest' => Carbon::now()->addDays(2), // Zber za 2 dni -> kolízia s karenčnou dobou
                'status' => 'warning'
            ],
            [
                'id' => 'R-03',
                'variety' => 'Veltlínske Zelené',
                'count' => 200,
                'last_treatment_date' => Carbon::now()->subDays(45),
                'last_treatment_type' => 'Rez',
                'planned_harvest' => Carbon::now()->addDays(10),
                'status' => 'ok'
            ],
        ];

        // Výpočet varovaní (ak je posledný postrek < 14 dní pred plánovanou žatvou)
        $alerts = [];
        foreach ($rows as $row) {
            $daysDiff = $row['last_treatment_date']->diffInDays($row['planned_harvest']);
            // Ak je postrek a rozdiel do zberu je menej ako 14 dní
            if (str_contains($row['last_treatment_type'], 'Postrek') && $daysDiff < 14) {
                $alerts[] = "POZOR: Riadok {$row['id']} ({$row['variety']}) má naplánovaný zber príliš skoro po postreku! (Karenčná doba)";
            }
        }

        return view('admin.dashboard', compact('rows', 'alerts'));
    }
}

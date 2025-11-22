<?php

namespace App\Http\Controllers;

use App\Models\WineBatch;
use Illuminate\Http\Request;

class WineBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', WineBatch::class); // Policy kontrola

        // Načítame vína aj s informáciami o úrode a vinohrade (cez opravený názov harvestDetail)
        $wineBatches = \App\Models\WineBatch::with(['harvestDetail.wineyardrow'])->get();

        // Ak je to zákazník, vyfiltrujeme len tie, čo sú na sklade (number_of_bottles > 0)
        if (auth()->user()->hasRole('customer')) {
            $wineBatches = $wineBatches->where('number_of_bottles', '>', 0);
        }

        return view('wine_batches.index', compact('wineBatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
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
        $wineBatches = WineBatch::with(['harvestDetail.wineyardrow'])->get();

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

    public function createFromHarvest(Request $request, Harvest $harvest)
    {
        // Kontrola: Len dokončenú sklizeň možno fľašovať
        if ($harvest->status !== 'completed') {
            return back()->with('error', 'Only completed harvests can be bottled.');
        }

        // Automatický výpočet (napr. 1kg hrozna = 0.7 fľaše)
        //$estimatedBottles = floor($harvest->weight_grapes * 0.7);

        // Predvyplníme údaje, aby vinár nemusel písať všetko od nuly
        $prefill = [
            'vintage' => $harvest->date_time->format('Y'),
            'variety' => $harvest->variety,
            'sugariness' => $harvest->sugariness,
            // Odhad: 1kg hrozna = cca 0.7 litra/fľaše (upravte podľa reality)
            'estimated_bottles' => floor($harvest->weight_grapes * 0.7),
        ];

        return view('wine_batches.create_from_harvest', compact('harvest', 'prefill'));
    }

    public function storeFromHarvest(Request $request, Harvest $harvest)
    {
        // Validácia vstupov od vinára
        $validated = $request->validate([
            'vintage' => 'required|integer|min:1900',
            'variety' => 'required|string|max:100',
            'sugariness' => 'required|integer|min:0',
            'alcohol_percentage' => 'required|numeric|min:0|max:20',
            'number_of_bottles' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Vytvorenie dávky vína
        WineBatch::create([
            'harvest' => $harvest->id_harvest, // Väzba na sklizeň
            'vintage' => $validated['vintage'],
            'variety' => $validated['variety'],
            'sugariness' => $validated['sugariness'],
            'alcohol_percentage' => $validated['alcohol_percentage'],
            'number_of_bottles' => $validated['number_of_bottles'],
            'price' => $validated['price'],
            'date_time' => now(),
        ]);

        // Uzavretie sklizne (aby sa nedala fľašovať znova)
        $harvest->update(['status' => 'bottled']);

        return redirect()->route('wine_batches.index')
            ->with('success', 'New wine batch created successfully!');
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
    public function edit(WineBatch $wine_batch)
    {
        //
        $this->authorize('update', $wine_batch);

        return view('wine_batches.edit', ['batch' => $wine_batch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WineBatch $wine_batch)
    {
        $this->authorize('update', $wine_batch);

        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'number_of_bottles' => 'required|integer|min:0',
            'sugariness' => 'required|integer|min:0',
            'alcohol_percentage' => 'required|numeric|min:0|max:20',
        ]);

        $wine_batch->update($validated);

        return redirect()->route('wine_batches.index')
            ->with('success', 'Wine batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WineBatch $wine_batch)
    {
        $this->authorize('delete', $wine_batch);

        $wine_batch->delete();

        return redirect()->route('wine_batches.index')
            ->with('success', 'Wine batch deleted.');
    }
}

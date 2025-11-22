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

        // Ak je to zákazník, vidí len vína, ktorých je viac ako 0 na sklade
        if (auth()->user()->hasRole('customer')) {
            $wineBatches = WineBatch::with(['harvestDetail', 'harvestDetail.winerow'])
                            ->where('quantity', '>', 0)
                            ->get();
        } else {
            // Admin a vinár vidia všetko
            $wineBatches = WineBatch::with(['harvestDetail', 'harvestDetail.winerow'])->get();
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

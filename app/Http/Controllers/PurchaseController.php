<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\WineBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $purchases = Purchase::with(['items.wineBatch.harvest.vineyard', 'buyer'])->latest('date_time')->paginate(10);
        } else {
            $purchases = Purchase::with(['items.wineBatch.harvest.vineyard'])
                        ->where('user', auth()->user()->login) // Používame login, nie ID
                        ->latest('date_time')
                        ->paginate(10);
        }

        return view('purchases.index', compact('purchases'));
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
        $request->validate([
            'wine_batch_id' => 'required|exists:winebatch,id_batch',
            'quantity' => 'required|integer|min:1',
        ]);

        // 1. Nájdeme víno
        $wineBatch = WineBatch::findOrFail($request->wine_batch_id);

        // 2. Skontrolujeme dostupnosť
        if ($wineBatch->quantity < $request->quantity) {
            return back()->with('error', 'Not enough bottles in stock!');
        }

        try {
            DB::transaction(function () use ($request, $wineBatch) {
                // 3. Vypočítame sumu
                $totalPrice = $wineBatch->price * $request->quantity;

                // 4. Vytvoríme Nákup (Hlavička)
                $purchase = Purchase::create([
                    'user' => auth()->user()->login, // Primárny kľúč je login
                    'date_time' => now(),
                    'total_price' => $totalPrice,
                ]);

                // 5. Vytvoríme Položku nákupu
                PurchaseItem::create([
                    'purchase' => $purchase->id_purchase,
                    'wine_batch' => $wineBatch->id_batch,
                    'quantity' => $request->quantity,
                    'price_per_unit' => $wineBatch->price,
                ]);

                // 6. Odpočítame zo skladu
                $wineBatch->decrement('quantity', $request->quantity);
            });

            return redirect()->route('purchases.index')->with('success', 'Wine purchased successfully! Cheers!');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong during purchase.');
        }
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

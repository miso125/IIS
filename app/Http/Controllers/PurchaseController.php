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
        $purchases = Purchase::with(['items.batch.harvestDetail.wineyardrow'])
            ->where('user', auth()->user()->login)
            ->latest('date_time')
            ->paginate(10);


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
            'wine_batch_id' => 'required|exists:winebatch,batch_number',
            'quantity' => 'required|integer|min:1',
        ]);

        $batch = WineBatch::findOrFail($request->wine_batch_id);

        if ($batch->number_of_bottles < $request->quantity) {
            return back()->with('error', 'Nedostatok tovaru na sklade.');
        }

        try {
            DB::transaction(function () use ($request, $batch) {
                $pricePerUnit = $batch->price;
                $totalPrice = $pricePerUnit * $request->quantity;

                // 1. Vytvoríme hlavičku nákupu
                $purchase = Purchase::create([
                    'user' => auth()->user()->login,
                    'date_time' => now(),
                    'total_price' => $totalPrice, // Opravený názov stĺpca
                ]);

                // 2. Vytvoríme položku
                PurchaseItem::create([
                    'purchase' => $purchase->id_purchase,
                    'wine_batch' => $batch->batch_number,
                    'number_of_bottles' => $request->quantity, // Váš názov stĺpca v purchaseitem
                    'item_price' => $pricePerUnit,
                    'stock' => true // Predpokladám, že toto znamená "vydané zo skladu"
                ]);

                // 3. Odpočítame zo skladu
                $batch->decrement('number_of_bottles', $request->quantity);
            });

            return redirect()->route('purchases.index')->with('success', 'Víno bolo úspešne zakúpené!');
        } catch (\Exception $e) {
            return back()->with('error', 'Chyba nákupu: ' . $e->getMessage());
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

<?php

namespace App\Http\Controllers;

use App\Models\WineyardRow;
use App\Http\Requests\StoreWineyardRowRequest;
use App\Http\Requests\UpdateWineyardRowRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WineyardRowController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('permission:view winerow', only: ['index', 'show']),
            new Middleware('permission:create winerow', only: ['create', 'store']),
            new Middleware('permission:edit winerow', only: ['edit', 'update']),
            new Middleware('permission:delete winerow', only: ['destroy']),
        ];
    }

    public function index()
    {
        $this->authorize('viewAny', WineyardRow::class);
        
        $winerows = WineyardRow::with('user')
            ->paginate(15);
        
        return view('vineyards.index', compact('winerows'));
    }

    public function create()
    {
        $this->authorize('create', WineyardRow::class);
        
        return view('vineyards.create');
    }

    public function store(StoreWineyardRowRequest $request)
    {
        $this->authorize('create', WineyardRow::class);
        
        $validated = $request->validated();
        
        // Automaticky pridelíme aktuálneho užívateľa ako vlastníka
        $validated['user'] = auth()->id();
        
        $winerow = WineyardRow::create($validated);
        
        return redirect()->route('vineyards.show', $winerow)
            ->with('success', 'Wineyard Row created.');
    }

    public function show(WineyardRow $winerow)
    {
        $this->authorize('view', $winerow);
        
        $harvests = $winerow->harvests()->paginate(10);
        $treatments = $winerow->treatments()->paginate(10);
        
        return view('vineyards.show', compact('winerow', 'harvests', 'treatments'));
    }

    public function edit(WineyardRow $winerow)
    {
        $this->authorize('update', $winerow);
        
        return view('vineyards.edit', compact('winerow'));
    }

    public function update(UpdateWineyardRowRequest $request, WineyardRow $winerow)
    {
        $this->authorize('update', $winerow);
        
        $validated = $request->validated();
        $winerow->update($validated);
        
        return redirect()->route('vineyards.show', $winerow)
            ->with('success', 'Wineyard Row updated.');
    }

    public function destroy(WineyardRow $winerow)
    {
        $this->authorize('delete', $winerow);
        
        $winerow->delete();
        
        return redirect()->route('vineyards.index')
            ->with('success', 'Wineyard Row deleted.');
    }
}

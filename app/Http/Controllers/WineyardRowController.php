<?php

namespace App\Http\Controllers;

use App\Models\WineyardRow;
use App\Http\Requests\StoreWineyardRowRequest;
use App\Http\Requests\UpdateWineyardRowRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

/**
 * Manages Wineyard Rows.
 */
class WineyardRowController extends Controller implements HasMiddleware
{
    /**
     * Define authorization middleware for the controller.
     */
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
    /**
     * Display a listing of wineyards.
     */
    public function index()
    {
        $this->authorize('viewAny', WineyardRow::class);
        
        if (auth()->user()->hasRole('admin')) {
            $winerows = WineyardRow::with('owner')->paginate(15);
        } else {
            $winerows = WineyardRow::where('user', auth()->user()->login) // FFilter based on login
                        ->paginate(15);
        }
        
        return view('vineyards.index', compact('winerows'));
    }

    /**
     * Show the form for creating a new wineyard.
     */
    public function create()
    {
        $this->authorize('create', WineyardRow::class);
        
        return view('vineyards.create');
    }

    /**
     * Store a newly created wineyard in the database.
     */
    public function store(StoreWineyardRowRequest $request)
    {
        $this->authorize('create', WineyardRow::class);
        
        $validated = $request->validated();
        
        // Assign user as owner
        $validated['user'] = auth()->user()->login;
        
        $winerow = WineyardRow::create($validated);
        
        return redirect()->route('vineyards.index'  )
            ->with('success', 'Wineyard Row created.');
    }

    /**
     * Display the specified wineyard details.
     */
    public function show(WineyardRow $winerow)
    {
        $this->authorize('view', $winerow);
        
        $harvests = $winerow->harvests()->paginate(10);
        $treatments = $winerow->treatments()->paginate(10);
        
        return view('vineyards.show', compact('winerow', 'harvests', 'treatments'));
    }

    /**
     * Show the form for editing the wineyard.
     */
    public function edit(WineyardRow $vineyard)
    {
        $this->authorize('update', $vineyard);
        
        return view('vineyards.edit', compact('vineyard'));
    }

    /**
     * Update the specified wineyard in storage.
     */
    public function update(UpdateWineyardRowRequest $request, WineyardRow $vineyard)
    {
        $this->authorize('update', $vineyard);
        
        $validated = $request->validate([
            'variety' => 'required|string|max:100',
            'number_of_vines' => 'required|integer|min:1|max:500',
            'planting_year' => 'required|integer|min:1900|max:' . now()->year,
            'colour' => 'required|in:white,red,pink',
        ]);

        $vineyard->update($validated);
        
        return redirect()->route('vineyards.index')
            ->with('success', 'Vineyard updated successfully.');
    }

    /**
     * Remove the specified wineyard from storage.
     */
    public function destroy(WineyardRow $vineyard)
    {
        $this->authorize('delete', $vineyard);
        
        $vineyard->delete();
        
        return redirect()->route('vineyards.index')
            ->with('success', 'Wineyard Row deleted.');
    }
}

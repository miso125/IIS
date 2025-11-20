<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\WineyardRow;
use App\Http\Requests\StoreHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HarvestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('permission:view harvest', only: ['index', 'show']),
            new Middleware('permission:create harvest', only: ['create', 'store']),
            new Middleware('permission:edit harvest', only: ['edit', 'update']),
            new Middleware('permission:delete harvest', only: ['destroy']),
        ];
    }

    public function index()
    {
        $this->authorize('viewAny', Harvest::class);
        
        $harvests = Harvest::with(['wineyardrow', 'user'])
            ->orderBy('date_time', 'desc')
            ->paginate(15);
        
        return view('harvests.index', compact('harvests'));
    }

    public function create()
    {
        $this->authorize('create', Harvest::class);
        
        // Len vinoradky prihláseneho užívateľa
        $wineyardrows = WineyardRow::where('user', auth()->id())
            ->get();
        
        return view('harvests.create', compact('wineyardrows'));
    }

    public function store(StoreHarvestRequest $request)
    {
        $this->authorize('create', Harvest::class);
        
        $validated = $request->validated();
        $validated['user'] = auth()->id();
        
        $harvest = Harvest::create($validated);
        
        return redirect()->route('harvests.show', $harvest)
            ->with('success', 'Harvest registered.');
    }

    public function show(Harvest $harvest)
    {
        $this->authorize('view', $harvest);
        
        $batches = $harvest->batches()->paginate(10);
        
        return view('harvests.show', compact('harvest', 'batches'));
    }

    public function edit(Harvest $harvest)
    {
        $this->authorize('update', $harvest);
        
        return view('harvests.edit', compact('harvest'));
    }

    public function update(UpdateHarvestRequest $request, Harvest $harvest)
    {
        $this->authorize('update', $harvest);
        
        $validated = $request->validated();
        $harvest->update($validated);
        
        return redirect()->route('harvests.show', $harvest)
            ->with('success', 'Harvest updated.');
    }

    public function destroy(Harvest $harvest)
    {
        $this->authorize('delete', $harvest);
        
        $harvest->delete();
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest deleted.');
    }
}

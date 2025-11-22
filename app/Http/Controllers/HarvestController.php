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
            new Middleware('can:viewAny,App\Models\Harvest', only: ['index']),
            new Middleware('can:create,App\Models\Harvest', only: ['create', 'store']),
            new Middleware('can:update,harvest', only: ['edit', 'update']),
            new Middleware('can:delete,harvest', only: ['destroy']),
        ];
    }

    public function index()
    {
        $harvests = Harvest::with(['wineyardrow', 'user'])
            ->orderBy('date_time', 'desc')
            ->paginate(15);
        
        return view('harvests.index', compact('harvests'));
    }

    public function create()
    {
        // Len vinoradky prihláseneho užívateľa
        // docasne all
        $wineyardrows = WineyardRow::all();
        
        return view('harvests.create', compact('wineyardrows'));
    }

    public function store(StoreHarvestRequest $request)
    {
        $validated = $request->validated();
        $validated['user'] = auth()->id();

        // Generate next id_harvest
        $last = Harvest::orderBy('id_harvest', 'desc')->first();
        $validated['id_harvest'] = $last ? $last->id_harvest + 1 : 1;
        $validated['date_time'] = \Carbon\Carbon::parse($validated['date_time'])
    ->format('Y-m-d H:i:s');

        $harvest = Harvest::create($validated);

        return redirect()->route('harvests.index', $harvest)
            ->with('success', 'Harvest registered.');
    }




    public function show(Harvest $harvest)
    {
        $batches = $harvest->batches()->paginate(10);
        
        return view('harvests.show', compact('harvest', 'batches'));
    }

    public function edit(Harvest $harvest)
    {
        // docasne all
        $wineyardrows = WineyardRow::all();

        return view('harvests.edit', compact('harvest', 'wineyardrows'));
    }

    public function update(UpdateHarvestRequest $request, Harvest $harvest)
    {
        $validated = $request->validated();
        $harvest->update($validated);
        
        return redirect()->route('harvests.index', $harvest)
            ->with('success', 'Harvest updated.');
    }
    public function destroy(Harvest $harvest)
    {
        $harvest->delete();
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest deleted.');
    }
}

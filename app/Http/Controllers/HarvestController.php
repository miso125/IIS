<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\WineyardRow;
use Illuminate\Http\Request;
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
        $user = auth()->user();
        // Vinár vidí všetko
        if ($user->hasRole(['admin', 'winemaker'])) {
            $harvests = Harvest::with(['wineyardrow', 'user'])
                ->orderBy('date_time', 'desc')
                ->paginate(15);
        } else {
            // Pracovník vidí len tie, ktoré má vykonať (planned) alebo ktoré vykonal on
            $harvests = Harvest::with(['wineyardrow', 'user'])
                ->where('status', 'planned')
                ->orWhere('user', $user->login)
                ->orderBy('date_time', 'desc')
                ->paginate(15);
        }
        
        return view('harvests.index', compact('harvests'));
    }

    public function create()
    {
        // Len vinoradky prihláseneho užívateľa
        // docasne all
        $wineyardrows = WineyardRow::all();
        
        return view('harvests.create', compact('wineyardrows'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'date_time' => 'required|date',
        ]);

        // Formátovanie dátumu (ak treba, ale date input to posiela väčšinou ok)
        $dateTime = \Carbon\Carbon::parse($validated['date_time']);

        // Vytvorenie "Plánovanej" sklizne
        $harvest = Harvest::create([
            'wine_row' => $validated['wine_row'],
            'date_time' => $dateTime,
            'status' => 'planned', // Dôležité: Stav je plánovaný
            
            // Ostatné polia (user, weight, sugar) sú NULL, lebo sa ešte nič neobralo
            'user' => null, 
            'weight_grapes' => null,
            'sugariness' => null,
            'variety' => null, // Môžeme neskôr doplniť z vinohradu
        ]);

        return redirect()->route('harvests.index')
            ->with('success', 'Harvest planned successfully. Workers can now see it.');
    }




    public function show(Harvest $harvest)
    {
        $batches = $harvest->batches()->paginate(10);
        
        return view('harvests.show', compact('harvest', 'batches'));
    }

    public function edit($id)
    {
        if (!auth()->user()->hasRole('winemaker|worker')) {
            abort(403);
        }

        // Worker can't edit finished harvests
        if (auth()->user()->hasRole('worker')) {
            $harvest = Harvest::findOrFail($id);

            if ($harvest->status === 'completed' || $harvest->status === 'bottled') {
                abort(403);
            }
        }

        return view('harvests.edit', compact('harvest'));
    }


    public function update(Request $request, Harvest $harvest)
    {
        // Tu už vyžadujeme výsledky práce
        $validated = $request->validate([
            'weight_grapes' => 'required|integer|min:1',
            'sugariness' => 'required|integer|min:10|max:35',
            'variety' => 'required|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Aktualizácia záznamu
        $harvest->update([
            'weight_grapes' => $validated['weight_grapes'],
            'sugariness' => $validated['sugariness'],
            'variety' => $validated['variety'],
            'notes' => $request->notes,
            
            // Dôležité zmeny stavu:
            'status' => 'completed',       // Označíme ako hotové
            'user' => auth()->user()->login, // Uložíme, KTO to vykonal (Pracovník)
        ]);
        
        // Ak bol zmenený aj dátum/vinohrad v edite (voliteľné), pridajte to sem
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest completed and recorded!');
    }
    public function destroy(Harvest $harvest)
    {
        $harvest->delete();
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest deleted.');
    }
}

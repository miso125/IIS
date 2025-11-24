<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\WineyardRow;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;

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
            'date_time' => 'required|string',
            'variety'   => 'required|string|max:100',
        ]);

        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $validated['date_time']);

        $treatments = \App\Models\Treatment::where('wine_row', $validated['wine_row'])
            ->whereIn('type', ['Chemical Spraying', 'Chemical'])
            ->get();

        foreach ($treatments as $treatment) {

            $treatmentDate = $treatment->planned_date
                ? Carbon::parse($treatment->planned_date)
                : Carbon::parse($treatment->date_time);

            if ($treatmentDate->lte($dateTime) && $treatmentDate->diffInDays($dateTime) < 14) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'date_time' =>
                            'Harvest cannot be planned within 14 days after a chemical treatment on '
                            . $treatmentDate->format('d.m.Y H:i') . '.',
                    ]);
            }
        }


        Harvest::create([
            'wine_row' => $validated['wine_row'],
            'date_time' => $dateTime,
            'status' => 'planned',
            'user' => null,
            'weight_grapes' => null,
            'sugariness' => null,
            'variety' => $validated['variety'],
        ]);

        return redirect()->route('harvests.index')
            ->with('success', 'Harvest planned successfully. Workers can now see it.');
    }





    public function show(Harvest $harvest)
    {
        $batches = $harvest->batches()->paginate(10);
        
        return view('harvests.show', compact('harvest', 'batches'));
    }

    public function edit(Harvest $harvest)
    {
        // all
        $wineyardrows = WineyardRow::all();

        return view('harvests.edit', compact('harvest', 'wineyardrows'));
    }

    public function update(Request $request, Harvest $harvest)
    {
        // Tu už vyžadujeme výsledky práce
        $rules = [
            'weight_grapes' => 'required|integer|min:1',
            'sugariness'    => 'required|integer|min:10|max:35',
            'variety'       => 'required|string|max:100',
            'notes'         => 'nullable|string',
        ];

        if (auth()->user()->hasRole('winemaker')) {
            $rules['date_time'] = 'required|string';
            $rules['wine_row']  = 'required|exists:wineyardrow,id_row';
        }

        
        $validated = $request->validate($rules);

        if (auth()->user()->hasRole('winemaker')) {
            $dateTime = Carbon::createFromFormat('d.m.Y H:i', $validated['date_time']);

            $treatments = \App\Models\Treatment::where('wine_row', $validated['wine_row'])
                ->whereIn('type', ['Chemical Spraying', 'Chemical'])
                ->get();

            foreach ($treatments as $treatment) {
                $treatmentDate = $treatment->planned_date
                    ? Carbon::parse($treatment->planned_date)
                    : Carbon::parse($treatment->date_time);

                if ($treatmentDate->lte($dateTime) && $treatmentDate->diffInDays($dateTime) < 14) {
                    return back()
                        ->withInput()
                        ->withErrors([
                            'date_time' => 'Harvest cannot be planned within 14 days after a chemical treatment on '
                                . $treatmentDate->format('d.m.Y') . '.',
                        ]);
                }
            }
        }

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
        
        if (auth()->user()->hasRole('winemaker')) {
            $harvest->update([
                'wine_row'   => $validated['wine_row'],
                'date_time'  => $dateTime,
            ]);
        }
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest completed and recorded!');
    }
    public function destroy(Harvest $harvest)
    {
        $harvest->delete();
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest deleted.');
    }

    public function checkChemical($wineRow, $date)
    {
        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $date);

        $treatments = \App\Models\Treatment::where('wine_row', $wineRow)
            ->whereIn('type', ['Chemical Spraying','Chemical'])
            ->get();

        foreach ($treatments as $treatment) {

            $treatmentDate = $treatment->planned_date
                ? Carbon::parse($treatment->planned_date)
                : Carbon::parse($treatment->date_time);

            if ($treatmentDate->lte($dateTime) && $treatmentDate->diffInDays($dateTime) < 14) {
                return response()->json([
                    'allowed' => false,
                    'message' =>
                        'NOT ALLOWED: Chemical treatment on '
                        . $treatmentDate->format('d.m.Y H:i')
                        . ' is less than 14 days before planned harvest.'
                ]);
            }
        }

        return response()->json(['allowed' => true]);
    }

    public function checkDate(Request $request)
    {
        $request->validate([
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'date_time' => 'required|string',
        ]);

        $row = $request->wine_row;
        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $request->date_time);

        $treatments = \App\Models\Treatment::where('wine_row', $row)
            ->whereIn('type', ['Chemical Spraying','Chemical'])
            ->get();

        foreach ($treatments as $treatment) {
            $tDate = Carbon::parse($treatment->date_time);

            if ($tDate->diffInDays($dateTime, false) >= 0 &&
                $tDate->diffInDays($dateTime, false) < 14) {

                return response()->json([
                    'valid' => false,
                    'message' => 'Harvest cannot be planned within 14 days after any chemical treatment.'
                ]);
            }
        }

        return response()->json(['valid' => true]);
    }




}

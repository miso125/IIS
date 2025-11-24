<?php

namespace App\Http\Controllers;

use App\Models\Harvest;
use App\Models\Treatment;
use App\Models\WineyardRow;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Carbon\Carbon;

/**
 * Manages the lifecycle of a Harvest.
 *
 * Workflow:
 * 1. Winemaker plans a harvest (store) -> status: 'planned'
 * 2. Worker views the plan (index)
 * 3. Worker executes the harvest and fills details (update) -> status: 'completed'
 */
class HarvestController extends Controller implements HasMiddleware
{
    /**
     * Define authorization middleware for the controller.
     */
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

    /**
     * Display a listing of harvests.
     */
    public function index()
    {
        $user = auth()->user();
        // Winemaker and admin can see everything
        if ($user->hasRole(['admin', 'winemaker'])) {
            $harvests = Harvest::with(['wineyardrow', 'user'])
                ->orderBy('date_time', 'desc')
                ->paginate(15);
        } else {
            // Worker sees tasks waiting to be done ('planned')
            $harvests = Harvest::with(['wineyardrow', 'user'])
                ->where('status', 'planned')
                ->orderBy('date_time', 'desc')
                ->paginate(15);
        }
        
        return view('harvests.index', compact('harvests'));
    }

    /**
     * Show the form for creating a new planned harvest.
     */
    public function create()
    {
        // WineyardRows of user
        $wineyardrows = WineyardRow::all();
        
        return view('harvests.create', compact('wineyardrows'));
    }

    /**
     * Store a newly planned harvest in the database.
     *
     * Validates that no chemical treatments have occurred within 
     * the safety period (14 days) before the planned date.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'date_time' => 'required|string',
        ]);

        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $validated['date_time']);

        $treatments = Treatment::where('wine_row', $validated['wine_row'])
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

        $selectedRow = WineyardRow::find($validated['wine_row']);

        $variety = $selectedRow ? $selectedRow->variety : null;

        // Create the harvest record
        Harvest::create([
            'wine_row' => $validated['wine_row'],
            'date_time' => $dateTime,
            'status' => 'planned',
            // null because we are only planning it
            'user' => null,
            'weight_grapes' => null,
            'sugariness' => null,
            'variety' => $variety,
        ]);

        return redirect()->route('harvests.index')
            ->with('success', 'Harvest planned successfully. Workers can now see it.');
    }

    /**
     * Display the specified harvest details.
     */
    public function show(Harvest $harvest)
    {
        $batches = $harvest->batches()->paginate(10);
        
        return view('harvests.show', compact('harvest', 'batches'));
    }

    /**
     * Show the form for editing/completing the harvest.
     */
    public function edit(Harvest $harvest)
    {
        // all
        $wineyardrows = WineyardRow::all();

        return view('harvests.edit', compact('harvest', 'wineyardrows'));
    }

    /**
     * Update the specified harvest in storage.
     *
     * Handles two scenarios based on user role
     */
    public function update(Request $request, Harvest $harvest)
    {
        // Update with outcome of job
        $rules = [
            'weight_grapes' => '',
            'sugariness'    => '',
            'date_time'     => '',
            'wine_row'      => '',
            'notes'         => 'nullable|string',
        ];

        if (auth()->user()->hasRole('winemaker')) {
            $rules['date_time'] = 'required|string';
            $rules['wine_row']  = 'required|exists:wineyardrow,id_row';
        }
        if (auth()->user()->hasRole('worker')) {
            $rules['weight_grapes'] = 'required|integer|min:1';
            $rules['sugariness']    = 'required|integer|min:10|max:35';
        }


        $validated = $request->validate($rules);

        if (auth()->user()->hasRole('winemaker')) {
            $dateTime = Carbon::createFromFormat('d.m.Y H:i', $validated['date_time']);

            $treatments = Treatment::where('wine_row', $validated['wine_row'])
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

        $selectedRow = WineyardRow::find($validated['wine_row']);

        $variety = $selectedRow ? $selectedRow->variety : null;

        // Harvest updating
        $harvest->update([
            'weight_grapes' => $validated['weight_grapes'],
            'sugariness' => $validated['sugariness'],
            'variety' => $variety,
            'notes' => $request->notes,
            
            // CHange of status
            'status' => 'completed',  
            'user' => auth()->user()->login, // Store who done it
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
    /**
     * Remove the specified harvest from storage.
     */
    public function destroy(Harvest $harvest)
    {
        $harvest->delete();
        
        return redirect()->route('harvests.index')
            ->with('success', 'Harvest deleted.');
    }

    /**
     * Helper: Check if chemical treatments conflict with a specific date.
     * * Used by frontend to validate dates in real-time.
     */
    public function checkChemical($wineRow, $date)
    {
        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $date);

        $treatments = Treatment::where('wine_row', $wineRow)
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

    /**
     * Helper: Alternative endpoint for validating dates via Request object.
     */
    public function checkDate(Request $request)
    {
        $request->validate([
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'date_time' => 'required|string',
        ]);

        $row = $request->wine_row;
        $dateTime = Carbon::createFromFormat('d.m.Y H:i', $request->date_time);

        $treatments = Treatment::where('wine_row', $row)
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

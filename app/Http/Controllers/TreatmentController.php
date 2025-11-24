<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\WineyardRow;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public static function middleware(): array
    {
        return [
            'auth',
            'role:worker' => ['only' => ['create','store','edit','update','destroy']],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Treatment::class);

        $treatments = Treatment::with('user')
            ->orderBy('date_time', 'desc')
            ->paginate(15);

        return view('treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wineRows = WineyardRow::all();
        return view('treatments.create', compact('wineRows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'treatment_product' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|between:0,100',
            'notes' => 'nullable|string',
            'planned_date' => 'nullable|date_format:d.m.Y',
            'is_completed' => 'nullable|boolean',
        ]);

        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        }

        if (!isset($validatedData['is_completed'])) {
            $validatedData['is_completed'] = false;
        } else {
            $validatedData['is_completed'] = true;
        }

        // assign  user
        $validatedData['user'] = auth()->user()->login;

        // assign current datetime
        $validatedData['date_time'] = now();

        Treatment::create($validatedData);

        return redirect()->route('treatments.index')->with('success', 'Treatment created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        return view('treatments.show', compact('treatment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $treatment = Treatment::findOrFail($id);

        $wineRows = WineyardRow::all();
        $this->authorize('update', $treatment);

        return view('treatments.edit', compact('treatment', 'wineRows'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'wine_row' => 'exists:wineyardrow,id_row',
            'treatment_product' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|between:0,100',
            'notes' => 'nullable|string',
            'planned_date' => 'nullable|date_format:d.m.Y',
            'is_completed' => 'nullable|boolean',
        ]);

        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        } else {
            $validatedData['planned_date'] = null;
        }

        $selectedRow = WineyardRow::find($validatedData['wine_row']);

        $validatedData['variety'] = $selectedRow ? $selectedRow->variety : null;


        $validatedData['is_completed'] = $request->boolean('is_completed');

        $treatment->update($validatedData);

        return redirect()->route('treatments.index')->with('success', 'Treatment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        $this->authorize('delete', $treatment);

        $treatment->delete();
        return redirect()->route('treatments.index')->with('success', 'Treatment deleted.');
    }
}

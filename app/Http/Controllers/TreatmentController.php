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
            'role:vinar|worker' => ['except' => ['show', 'index']],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatment::all();
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
            'spray_used' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|between:0,100',
            'note' => 'nullable|string',
            'planned_date' => 'nullable|date_format:d.m.Y',
            'is_completed' => 'nullable|boolean',
        ]);

        // Convert date format for database storage
        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        }

        // Assign current user
        $validatedData['user'] = auth()->user()->login;

        // Assign current datetime for NOT NULL column
        $validatedData['date_time'] = now();

        Treatment::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Treatment created successfully.');
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
    public function edit(Treatment $treatment)
    {
        return view('treatments.edit', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'wine_row' => 'required|exists:wineyardrow,id_row',
            'spray_used' => 'nullable|string|max:255',
            'concentration' => 'nullable|numeric|between:0,100',
            'note' => 'nullable|string',
            'planned_date' => 'nullable|date_format:d.m.Y',
            'is_completed' => 'nullable|boolean',
        ]);

        // Convert date format for database storage
        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        } else {
            $validatedData['planned_date'] = null;
        }

        $treatment->update($validatedData);

        return redirect()->route('treatments.index')->with('success', 'Treatment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->route('treatments.index')->with('success', 'Treatment deleted.');
    }
}

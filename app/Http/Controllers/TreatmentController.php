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
            // Only restrict creation/updating/deleting to roles, index/show open to vinar
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

        // Convert date format for database storage
        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        }

        // Handle checkbox for is_completed
        if (!isset($validatedData['is_completed'])) {
            $validatedData['is_completed'] = false;
        } else {
            $validatedData['is_completed'] = true;
        }

        // Assign current user
        $validatedData['user'] = auth()->user()->login;

        // Assign current datetime for NOT NULL column
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
        // Find the treatment by its ID, or fail with a 404 error if not found.
        $treatment = Treatment::findOrFail($id);

        // This will use the 'update' method in your TreatmentPolicy
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

        // Convert date format for database storage
        if (isset($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['planned_date'])->format('Y-m-d');
        } else {
            $validatedData['planned_date'] = null;
        }

        // Handle checkbox for is_completed
        if (!isset($validatedData['is_completed'])) {
            $validatedData['is_completed'] = false;
        } else {
            $validatedData['is_completed'] = true;
        }

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

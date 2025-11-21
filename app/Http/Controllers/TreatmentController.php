<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
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
            'role:vinar|worker' => ['only' => ['create', 'store']],
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
        return view('treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'spray_used' => 'nullable|string|max:255',
            'concentration' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'planned_date' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
        ]);

        if (!empty($validatedData['planned_date'])) {
            $validatedData['planned_date'] = \Carbon\Carbon::parse($validatedData['planned_date'])
                ->format('d.m.Y');
        }

        Treatment::create($validatedData);

        return redirect()->route('dashboard')
                        ->with('success', 'Treatment created successfully.');
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $treatment->update($validated);

        return redirect()->route('treatments.show', $treatment)->with('success', 'Treatment updated.');
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

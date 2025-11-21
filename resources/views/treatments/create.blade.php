@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Treatment</h1>

        <form action="{{ route('treatments.store') }}" method="POST">
            @csrf


        <div class="form-group">
            <label for="wine_row">Wine Row:</label>
            <select class="form-control" id="wine_row" name="wine_row" required>
                <option value="" disabled {{ old('wine_row') ? '' : 'selected' }}>Select a wine row</option>
                @foreach($wineRows as $row)
                    <option value="{{ $row->id_row }}" {{ old('wine_row') == $row->id_row ? 'selected' : '' }}>
                        {{ $row->variety }} ({{ $row->planting_year }}) - {{ $row->colour }}
                    </option>
                @endforeach
            </select>
        </div>



            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" disabled selected>Select a treatment type</option>
                    <option value="Watering">Watering</option>
                    <option value="Chemical Spraying">Chemical Spraying</option>
                    <option value="Cutting Trees">Cutting Trees</option>
                    <option value="Fertilizing">Fertilizing</option>
                    <option value="Pruning">Pruning</option>
                </select>
            </div>

            <div id="chemical_fields" style="display: none;">
                <div class="form-group">
                    <label for="spray_used">Spray Used:</label>
                    <input type="text" class="form-control" id="spray_used" name="spray_used">
                </div>
                
                <div class="form-group">
                    <label for="concentration">Concentration:</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="concentration" name="concentration" min="0" max="100" step="0.01">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="note">Note:</label>
                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="planned_date">Planned Date:</label>

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

                <input type="text" id="planned_date" name="planned_date" class="form-control"
                    placeholder="dd.mm.yyyy" value="{{ now()->format('d.m.Y') }}">


            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1">
                <label class="form-check-label" for="is_completed">Completed</label>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('treatments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#planned_date", {
            dateFormat: "d.m.Y",
            defaultDate: "{{ now()->format('d.m.Y') }}",   // today by default
        });

        // Existing logic for showing chemical fields
        const typeSelect = document.getElementById('type');
        const chemicalFields = document.getElementById('chemical_fields');

        function toggleChemicalFields() {
            chemicalFields.style.display = typeSelect.value === 'Chemical Spraying' ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleChemicalFields);
    });
    </script>

@endsection

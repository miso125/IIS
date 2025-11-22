@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Treatment</h1>

        <form action="{{ route('treatments.update', $treatment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label class="form-label">Wine Row:</label>
                <div class="form-control-plaintext border rounded px-2 py-1 bg-light">
                    {{ $treatment->wine_row }}
                </div>
            </div>


            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" disabled>Select a treatment type</option>
                    <option value="Watering" {{ old('type', $treatment->type) == 'Watering' ? 'selected' : '' }}>Watering</option>
                    <option value="Chemical Spraying" {{ old('type', $treatment->type) == 'Chemical Spraying' ? 'selected' : '' }}>Chemical Spraying</option>
                    <option value="Cutting Trees" {{ old('type', $treatment->type) == 'Cutting Trees' ? 'selected' : '' }}>Cutting Trees</option>
                    <option value="Fertilizing" {{ old('type', $treatment->type) == 'Fertilizing' ? 'selected' : '' }}>Fertilizing</option>
                    <option value="Pruning" {{ old('type', $treatment->type) == 'Pruning' ? 'selected' : '' }}>Pruning</option>
                </select>
            </div>

            <div id="chemical_fields" style="{{ old('type', $treatment->type) == 'Chemical Spraying' ? 'display: block;' : 'display: none;' }}">
                <div class="form-group">
                    <label for="treatment_product">Spray Used:</label>
                    <input type="text" class="form-control" id="treatment_product" name="treatment_product" value="{{ old('treatment_product', $treatment->treatment_product) }}">
                </div>
                
                <div class="form-group">
                    <label for="concentration">Concentration:</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="concentration" name="concentration" min="0" max="100" step="0.01" value="{{ old('concentration', $treatment->concentration) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Note:</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $treatment->notes) }}</textarea>
            </div>

            <div class="form-group">
                <label for="planned_date">Planned Date:</label>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                <input type="text" id="planned_date" name="planned_date" class="form-control"
                    placeholder="dd.mm.yyyy" value="{{ old('planned_date', \Carbon\Carbon::parse($treatment->planned_date)->format('d.m.Y')) }}">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_completed" name="is_completed" value="1" {{ old('is_completed', $treatment->is_completed) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_completed">Completed</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Treatment</button>
            <a href="{{ route('treatments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#planned_date", {
            dateFormat: "d.m.Y",
            minDate: "today",
        });

        const typeSelect = document.getElementById('type');
        const chemicalFields = document.getElementById('chemical_fields');

        function toggleChemicalFields() {
            chemicalFields.style.display = typeSelect.value === 'Chemical Spraying' ? 'block' : 'none';
        }

        // Initial check
        toggleChemicalFields();

        typeSelect.addEventListener('change', toggleChemicalFields);
    });
    </script>
@endsection
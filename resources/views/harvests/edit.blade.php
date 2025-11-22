@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Harvest</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('harvests.update', $harvest) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="wine_row" class="form-label">Wineyard Row</label>
            <select class="form-control" id="wine_row" name="wine_row" required>
                <option value="">Select a wineyard row</option>
                @foreach ($wineyardrows as $row)
                    <option value="{{ $row->id_row }}" {{ old('wine_row', $harvest->wine_row) == $row->id_row ? 'selected' : '' }}>
                        {{ $row->id_row }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="weight_grapes" class="form-label">Weight of Grapes (kg)</label>
            <input type="number" step="0.01" class="form-control" id="weight_grapes" name="weight_grapes" value="{{ old('weight_grapes', $harvest->weight_grapes) }}" required>
        </div>

        <div class="mb-3">
            <label for="variety" class="form-label">Variety</label>
            <input type="text" class="form-control" id="variety" name="variety" value="{{ old('variety', $harvest->variety) }}" required>
        </div>

        <div class="mb-3">
            <label for="sugariness" class="form-label">Sugariness (°NM)</label>
            <input type="number" step="0.1" class="form-control" id="sugariness" name="sugariness" value="{{ old('sugariness', $harvest->sugariness) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_time" class="form-label">Date and Time of Harvest</label>
            <input type="text" class="form-control" id="date_time" name="date_time" value="{{ old('date_time', $harvest->date_time) }}" required>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#date_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                maxDate: new Date(),
                defaultDate: "{{ old('date_time', \Carbon\Carbon::parse($harvest->date_time)->format('Y-m-d H:i')) }}"
            });
        });
        </script>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $harvest->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Harvest</button>
        <a href="{{ route('harvests.show', $harvest) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
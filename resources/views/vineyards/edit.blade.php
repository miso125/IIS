@extends('layouts.app')

@section('title', 'Edit Vineyard')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Vineyard: {{ $vineyard->variety }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('vineyards.update', $vineyard) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="variety" class="form-label">Variety</label>
                            <input type="text" class="form-control" name="variety" 
                                   value="{{ old('variety', $vineyard->variety) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="number_of_vines" class="form-label">Number of Vines</label>
                            <input type="number" class="form-control" name="number_of_vines" 
                                   value="{{ old('number_of_vines', $vineyard->number_of_vines) }}" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="planting_year" class="form-label">Planting Year</label>
                            <input type="number" class="form-control" name="planting_year" 
                                   value="{{ old('planting_year', $vineyard->planting_year) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="colour" class="form-label">Color</label>
                            <select class="form-select" name="colour" required>
                                <option value="white" {{ $vineyard->colour == 'white' ? 'selected' : '' }}>White</option>
                                <option value="red" {{ $vineyard->colour == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="pink" {{ $vineyard->colour == 'pink' ? 'selected' : '' }}>Pink</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('vineyards.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Vineyard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Add Vineyard')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Add New Vineyard</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('vineyards.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="variety" class="form-label">Variety <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('variety') is-invalid @enderror" 
                                   id="variety" name="variety" value="{{ old('variety') }}" required>
                            @error('variety')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="number_of_vines" class="form-label">Number of Vines <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('number_of_vines') is-invalid @enderror" 
                                   id="number_of_vines" name="number_of_vines" value="{{ old('number_of_vines') }}" min="1" required>
                            @error('number_of_vines')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="planting_year" class="form-label">Planting Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('planting_year') is-invalid @enderror" 
                                   id="planting_year" name="planting_year" value="{{ old('planting_year', now()->year) }}" 
                                   min="1900" max="{{ now()->year }}" required>
                            @error('planting_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="colour" class="form-label">Color <span class="text-danger">*</span></label>
                            <select class="form-select @error('colour') is-invalid @enderror" id="colour" name="colour" required>
                                <option value="">-- Select Color --</option>
                                <option value="white" {{ old('colour') == 'white' ? 'selected' : '' }}>White</option>
                                <option value="red" {{ old('colour') == 'red' ? 'selected' : '' }}>Red</option>
                                <option value="pink" {{ old('colour') == 'pink' ? 'selected' : '' }}>Pink</option>
                            </select>
                            @error('colour')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('vineyards.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Create Vineyard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
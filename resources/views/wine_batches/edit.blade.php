@extends('layouts.app')

@section('title', 'Edit Wine Batch')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Batch #{{ $batch->batch_number }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('wine_batches.update', $batch) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Price (€)</label>
                                <input type="number" step="0.01" name="price" class="form-control" 
                                       value="{{ old('price', $batch->price) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock (Bottles)</label>
                                <input type="number" name="number_of_bottles" class="form-control" 
                                       value="{{ old('number_of_bottles', $batch->number_of_bottles) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Sugar Content (°NM)</label>
                                <input type="number" name="sugariness" class="form-control" 
                                       value="{{ old('sugariness', $batch->sugariness) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alcohol (%)</label>
                                <input type="number" step="0.1" name="alcohol_percentage" class="form-control" 
                                       value="{{ old('alcohol_percentage', $batch->alcohol_percentage) }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('wine_batches.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Batch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
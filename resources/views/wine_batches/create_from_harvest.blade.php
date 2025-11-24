@extends('layouts.app')

@section('title', 'Bottle Harvest')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-wine-bottle"></i> Bottle Harvest #{{ $harvest->id_harvest }}</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <strong>Source Harvest:</strong> {{ $harvest->weight_grapes }}kg of {{ $harvest->variety }} 
                        (Sugar: {{ $harvest->sugariness }}°NM)
                    </div>

                    <form action="{{ route('harvests.bottle.store', $harvest) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Variety</label>
                                <input type="text" name="variety" class="form-control" 
                                       value="{{ old('variety', $prefill['variety']) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vintage (Year)</label>
                                <input type="number" name="vintage" class="form-control" 
                                       value="{{ old('vintage', $prefill['vintage']) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Sugar Content (°NM)</label>
                                <input type="number" name="sugariness" class="form-control" 
                                       value="{{ old('sugariness', $prefill['sugariness']) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alcohol (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.1" name="alcohol_percentage" class="form-control" 
                                       value="{{ old('alcohol_percentage') }}" placeholder="e.g. 12.5" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Number of Bottles produced</label>
                                <input type="number" name="number_of_bottles" class="form-control" 
                                       value="{{ old('number_of_bottles', $prefill['estimated_bottles']) }}" required>
                                <small class="text-muted">Estimated from weight (0.7L/kg)</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Selling Price per Bottle (€)</label>
                                <input type="number" step="0.01" name="price" class="form-control" 
                                       value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Create Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
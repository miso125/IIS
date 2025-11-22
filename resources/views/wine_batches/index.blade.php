@extends('layouts.app')

@section('title', 'Ponuka vín')

@section('content')
<div class="container py-4">
    @role('customer')
        <h2 class="mb-4"><i class="fas fa-wine-bottle"></i> Naša ponuka vín</h2>
        <div class="row">
            @foreach($wineBatches as $batch)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 fw-bold">{{ $batch->harvestDetail->wineyardrow->variety ?? 'Neznáma odroda' }}</h5>
                            <small>Ročník {{ $batch->vintage }}</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <p class="mb-1"><strong>Farba:</strong> {{ ucfirst($batch->harvestDetail->wineyardrow->colour ?? '-') }}</p>
                                <p class="mb-1"><strong>Cukornatosť:</strong> {{ $batch->sugariness }} °NM</p>
                                <p class="mb-1 text-success"><strong>Skladom:</strong> {{ $batch->number_of_bottles }} ks</p>
                            </div>

                            <h3 class="text-center text-primary mb-3 fw-bold"> {{ $batch->price }} €</h3> <div class="mt-auto">
                                <form action="{{ route('purchases.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="wine_batch_id" value="{{ $batch->batch_number }}">
                                    
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $batch->number_of_bottles }}">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-shopping-cart"></i> Kúpiť
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Ste prihlásený ako personál.</div>
    @endrole
</div>
@endsection
@extends('layouts.app')

@section('title', 'Wine Selection')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-wine-bottle"></i> Wine Selection</h2>

    @role('customer')
        <div class="row">
            @foreach($wineBatches as $batch)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-light text-center">
                            <h5 class="mb-0">{{ $batch->harvestDetail->vineyard->variety ?? 'Unknown Variety' }}</h5>
                            <small class="text-muted">{{ $batch->harvestDetail->year }}</small>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Type:</strong> {{ ucfirst($batch->harvestDetail->vineyard->colour ?? '') }}<br>
                                <strong>Quality:</strong> {{ $batch->harvestDetail->quality_classification }}<br>
                                <strong>Available:</strong> {{ $batch->quantity }} bottles
                            </p>
                            <h3 class="text-primary text-center mb-3">{{ number_format($batch->price, 2) }} €</h3>
                            
                            <form action="{{ route('purchases.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="wine_batch_id" value="{{ $batch->batch_number }}">
                                
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Qty</span>
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $batch->quantity }}">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-shopping-cart"></i> Buy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Batch ID</th>
                            <th>Variety</th>
                            <th>Year</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wineBatches as $batch)
                        <tr>
                            <td>{{ $batch->id_batch }}</td>
                            <td>{{ $batch->harvestDetail->vineyard->variety ?? '-' }}</td>
                            <td>{{ $batch->harvestDetail->year }}</td>
                            <td>{{ $batch->quantity }} pcs</td>
                            <td>{{ number_format($batch->price, 2) }} €</td>
                            <td>
                                <a href="{{ route('wine_batches.edit', $batch) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endrole
</div>
@endsection
@extends('layouts.app')

@section('title', 'Ponuka vín')

@section('content')
<div class="container py-4">
    @role('customer')
        <h2 class="mb-4"><i class="fas fa-wine-bottle"></i> Our wine offer</h2>
        <div class="row">
            @foreach($wineBatches as $batch)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 fw-bold">{{ $batch->harvestDetail->wineyardrow->variety ?? 'Neznáma odroda' }}</h5>
                            <small>Vintage {{ $batch->vintage }}</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <p class="mb-1"><strong>Color:</strong> {{ ucfirst($batch->harvestDetail->wineyardrow->colour ?? '-') }}</p>
                                <p class="mb-1"><strong>Sugar Content:</strong> {{ $batch->sugariness }} °NM</p>
                                <p class="mb-1 text-success"><strong>Stock:</strong> {{ $batch->number_of_bottles }} ks</p>
                            </div>

                            <h3 class="text-center text-primary mb-3 fw-bold"> {{ $batch->price }} €</h3> <div class="mt-auto">
                                <form action="{{ route('purchases.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="wine_batch_id" value="{{ $batch->batch_number }}">
                                    
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $batch->number_of_bottles }}">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-shopping-cart"></i> Buy
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endrole
    @role('winemaker|admin')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-clipboard-list"></i> Wine Batch Management</h2>
            {{-- You might want a button to create a batch manually, though usually it's from Harvest --}}
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Batch #</th>
                                <th>Variety & Vintage</th>
                                <th>Details</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wineBatches as $batch)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $batch->batch_number }}</td>
                                    
                                    <td>
                                        <span class="fw-bold text-primary">
                                            {{ $batch->variety ?? 'Unknown' }}
                                        </span>
                                        <br>
                                        <small class="text-muted">Vintage {{ $batch->vintage }}</small>
                                    </td>

                                    <td>
                                        <small>
                                            <i class="fas fa-tint"></i> {{ ucfirst($batch->harvestDetail->wineyardrow->colour ?? '-') }}<br>
                                            <i class="fas fa-flask"></i> {{ $batch->sugariness }} °NM
                                        </small>
                                    </td>

                                    <td>
                                        @if($batch->number_of_bottles > 0)
                                            <span class="badge bg-success">{{ $batch->number_of_bottles }} bottles</span>
                                        @else
                                            <span class="badge bg-danger">Sold Out</span>
                                        @endif
                                    </td>

                                    <td class="fw-bold">
                                        {{ number_format($batch->price, 2) }} €
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('wine_batches.edit', $batch) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            
                                            <form action="{{ route('wine_batches.destroy', $batch) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will remove the batch from sales.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        {{-- This part is for Customers (The Shop View) --}}
        {{-- ... your existing card layout for customers goes here ... --}}
    @endrole
</div>
@endsection
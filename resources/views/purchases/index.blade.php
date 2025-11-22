@extends('layouts.app')

@section('title', 'Moja História')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-history"></i> My Purchases</h2>

    @if($purchases->isEmpty())
        <div class="alert alert-warning">
            You don't have any purchases yet. <a href="{{ route('wine_batches.index') }}">Go to store</a>
        </div>
    @else
        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Wine</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end pe-4">Total price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            {{-- Tu je to použitie ITEMS: prechádzame všetky položky jedného nákupu --}}
                            @foreach($purchase->items as $item)
                                <tr>
                                    <td class="ps-4">{{ $purchase->date_time->format('d.m.Y H:i:s') }}</td>
                                    <td>
                                        <span class="fw-bold text-primary">
                                            {{ $item->batch->harvestDetail->wineyardrow->variety ?? 'Víno' }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            Vintage {{ $item->batch->vintage ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->number_of_bottles }} ks
                                    </td>
                                    <td class="text-end pe-4 fw-bold">
                                        {{ number_format($purchase->total_price, 2) }} €
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $purchases->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'My Purchases')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-history"></i> Purchase History</h2>

    <div class="card shadow">
        <div class="card-body">
            @if($purchases->isEmpty())
                <p class="text-center text-muted my-4">You haven't purchased any wine yet.</p>
                <div class="text-center">
                    <a href="{{ route('wine_batches.index') }}" class="btn btn-primary">Go to Shop</a>
                </div>
            @else
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Wine Details</th> <th class="text-center">Quantity</th>
                            <th class="text-end">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            @foreach($purchase->items as $item)
                                <tr>
                                    <td>{{ $purchase->date_time->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <strong>
                                            {{ $item->wineBatch->harvest->vineyard->variety ?? 'Unknown Wine' }}
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            Vintage {{ $item->wineBatch->harvestDetail->year ?? '-' }}
                                        </small>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }} pcs</td>
                                    <td class="text-end fw-bold">{{ number_format($purchase->sum, 2) }} €</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-3">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
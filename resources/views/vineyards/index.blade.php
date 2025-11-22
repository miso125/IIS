@extends('layouts.app')

@section('title', 'My Vineyards')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-leaf"></i> My Vineyards</h2>
        </div>
        <div class="col-md-4 text-end">
            @can('create winerow') {{-- Opravený názov permission --}}
                <a href="{{ route('vineyards.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Vineyard
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        {{-- V controlleri posielame premennú $winerows, nie $vineyards --}}
        @forelse($winerows as $vineyard)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header" 
                         style="background-color: {{ $vineyard->colour == 'white' ? '#f5f0e8' : '#8B0000' }}; 
                                color: {{ $vineyard->colour == 'white' ? '#000' : '#fff' }};">
                        <h5 class="mb-0 fw-bold">{{ $vineyard->variety }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong><i class="fas fa-leaf"></i> Vines:</strong> {{ $vineyard->number_of_vines }}
                        </p>
                        <p class="mb-2">
                            <strong><i class="fas fa-calendar"></i> Planted:</strong> {{ $vineyard->planting_year }}
                        </p>
                        <p class="mb-3">
                            <strong><i class="fas fa-palette"></i> Color:</strong>
                            <span class="badge bg-secondary">
                                {{ ucfirst($vineyard->colour) }}
                            </span>
                        </p>
                    </div>
                    <div class="card-footer bg-light border-top-0">
                        <div class="d-flex justify-content-between gap-2">
                            @can('edit winerow')
                                <a href="{{ route('vineyards.edit', $vineyard) }}" class="btn btn-sm btn-warning flex-fill">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan

                            @can('delete winerow')
                                <form action="{{ route('vineyards.destroy', $vineyard) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to delete this vineyard? All harvests associated with it will be affected.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No vineyards found. 
                    <a href="{{ route('vineyards.create') }}">Create one now</a>.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $winerows->links() }}
    </div>
@endsection
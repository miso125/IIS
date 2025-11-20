@extends('layouts.app')

@section('title', 'My Vineyards')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-leaf"></i> My Vineyards</h2>
        </div>
        <div class="col-md-4 text-end">
            @can('create vineyard')
                <a href="{{ route('vineyards.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Vineyard
                </a>
            @endcan
        </div>
    </div>

    <div class="row">
        @forelse($vineyards as $vineyard)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header" 
                         style="background-color: {{ $vineyard->barva == 'white' ? '#f5f0e8' : '#8B0000' }}; color: #000;">
                        <h5 class="mb-0">{{ $vineyard->odroda }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong><i class="fas fa-leaf"></i> Heads:</strong> {{ $vineyard->pocet_hlav }}
                        </p>
                        <p class="mb-2">
                            <strong><i class="fas fa-calendar"></i> Planted:</strong> {{ $vineyard->rok_vysadby }}
                        </p>
                        <p class="mb-3">
                            <strong><i class="fas fa-palette"></i> Color:</strong>
                            <span class="badge" style="background-color: {{ $vineyard->barva == 'white' ? '#ffc107' : '#8B0000' }};">
                                {{ ucfirst($vineyard->barva) }}
                            </span>
                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-info-circle"></i> Responsible: {{ $vineyard->zodpovedna_os }}
                        </p>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="btn-group w-100" role="group">
                            @can('view vineyard')
                                <a href="{{ route('vineyards.show', $vineyard) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            @endcan
                            @can('edit vineyard')
                                <a href="{{ route('vineyards.edit', $vineyard) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan
                            @can('delete vineyard')
                                <form action="{{ route('vineyards.destroy', $vineyard) }}" method="POST" style="display: inline; flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                            onclick="return confirm('Delete this vineyard?')">
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
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> <strong>No vineyards yet.</strong>
                    @can('create vineyard')
                        <a href="{{ route('vineyards.create') }}" class="alert-link">Create your first vineyard</a>
                    @endcan
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($vineyards instanceof \Illuminate\Pagination\Paginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $vineyards->links() }}
        </div>
    @endif
@endsection

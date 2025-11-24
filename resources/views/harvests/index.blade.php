@extends('layouts.app')

@section('content')
<div class="container">
    @role('winemaker')
        <h1 class="mb-4">Harvests</h1>

        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('harvests.create') }}" class="btn btn-primary">
                Register New Harvest
            </a>
        </div>

        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Wineyard Row</th>
                    <th>Weight (kg)</th>
                    <th>Variety</th>
                    <th>Sugariness (°NM)</th>
                    <th>Date & Time</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($harvests as $harvest)
                    <tr>
                        <td>{{ $harvest->id_harvest }}</td>
                        <td>{{ $harvest->wine_row }}</td>
                        <td>{{ $harvest->weight_grapes }}</td>
                        <td>{{ $harvest->variety }}</td>
                        <td>{{ $harvest->sugariness }}</td>
                        <td>{{ \Carbon\Carbon::parse($harvest->date_time)->format('d.m.Y H:i') }}</td>

                        <td>
                            <a href="{{ route('harvests.edit', $harvest->id_harvest) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('harvests.destroy', $harvest->id_harvest) }}"
                                method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                            @if($harvest->status == 'completed')
                                <td>
                                    <a href="{{ route('harvests.bottle.create', $harvest) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-wine-bottle"></i> Bottle This
                                    </a>
                                </td>
                            @elseif($harvest->status == 'bottled')
                                <span class="badge bg-success">Bottled</span>
                            @else
                                <span class="badge bg-warning">Planned</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-4">No harvests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous --}}
                    @if ($harvests->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $harvests->previousPageUrl() }}">&laquo; Previous</a>
                        </li>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($harvests->links()->elements[0] ?? [] as $page => $url)
                        <li class="page-item {{ $page == $harvests->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Next --}}
                    @if ($harvests->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $harvests->nextPageUrl() }}">Next &raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next &raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endrole
    @role('worker')
        <h1 class="mb-4">Harvests</h1>

        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Wineyard Row</th>
                    <th>Weight (kg)</th>
                    <th>Variety</th>
                    <th>Sugariness (°NM)</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($harvests as $harvest)
                    <tr>
                        <td>{{ $harvest->id_harvest }}</td>
                        <td>{{ $harvest->wine_row }}</td>
                        <td>{{ $harvest->weight_grapes }}</td>
                        <td>{{ $harvest->variety }}</td>
                        <td>{{ $harvest->sugariness }}</td>
                        <td>{{ \Carbon\Carbon::parse($harvest->date_time)->format('d.m.Y H:i') }}</td>

                        <td>
                            @if($harvest->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($harvest->status == 'bottled')
                                <span class="badge bg-success">Bottled</span>
                            @else
                                <span class="badge bg-warning">Planned</span>
                            @endif
                        </td>
                        
                        <td>
                            @if($harvest->status != 'bottled')
                            <a href="{{ route('harvests.edit', $harvest->id_harvest) }}" 
                            class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            @endif
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-4">No harvests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{-- Previous --}}
                    @if ($harvests->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo; Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $harvests->previousPageUrl() }}">&laquo; Previous</a>
                        </li>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($harvests->links()->elements[0] ?? [] as $page => $url)
                        <li class="page-item {{ $page == $harvests->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Next --}}
                    @if ($harvests->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $harvests->nextPageUrl() }}">Next &raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next &raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endrole
</div>
@endsection

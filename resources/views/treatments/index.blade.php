@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Treatments</h1>

    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('treatments.create') }}" class="btn btn-primary">
            Create New Treatment
        </a>
    </div>

    @if ($treatments->isEmpty())
        <div class="alert alert-info text-center">
            No treatments found.
        </div>
    @else
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Wine Row</th>
                    <th>Variety</th>
                    <th>Planned Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($treatments as $treatment)
                    <tr>
                        <td>{{ $treatment->id_treatment }}</td>

                        <td>
                            {{ $treatment->type }}

                            @if ($treatment->notes)
                                <i class="fas fa-question-circle text-secondary ms-1"
                                   data-bs-toggle="tooltip"
                                   title="{{ $treatment->notes }}"
                                   style="cursor: help;"></i>
                            @endif
                        </td>

                        <td>{{ $treatment->wine_row }}</td>
                        <td>{{ $treatment->winerow->variety ?? '' }}</td>

                        <td>
                            {{ $treatment->planned_date
                                ? \Carbon\Carbon::parse($treatment->planned_date)->format('d.m.Y')
                                : 'N/A' }}
                        </td>

                        <td>
                            @if ($treatment->is_completed)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning text-dark">Planned</span>
                            @endif
                        </td>
                        @role('winemaker')
                        <td>
                            <a href="{{ route('treatments.edit', $treatment) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('treatments.destroy', $treatment) }}"
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
                        </td>
                        @endrole

                        @role('worker')
                        <td>
                            <form action="{{ route('treatments.update', $treatment->id_treatment) }}" 
                                method="POST" 
                                style="display:inline-block;">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="type" value="{{ $treatment->type }}">
                                <input type="hidden" name="wine_row" value="{{ $treatment->wine_row }}">
                                <input type="hidden" name="treatment_product" value="{{ $treatment->treatment_product }}">
                                <input type="hidden" name="concentration" value="{{ $treatment->concentration }}">
                                <input type="hidden" name="notes" value="{{ $treatment->notes }}">
                                <input type="hidden" name="planned_date" value="{{ $treatment->planned_date }}">

                                @if($treatment->is_completed)
                                    <input type="hidden" name="is_completed" value="0">
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        Undo
                                    </button>
                                @else
                                    <input type="hidden" name="is_completed" value="1">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Complete
                                    </button>
                                @endif
                            </form>
                        </td>
                        @endrole



                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- pagination --}}
        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Treatments pagination">
                <ul class="pagination">
                    {{-- Previous --}}
                    @if ($treatments->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">&laquo; Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $treatments->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                        </li>
                    @endif

                    @php
                        $start = 1;
                        $end = $treatments->lastPage();
                        // Optional: show a window around current page instead of all pages:
                        $window = 3;
                        $current = $treatments->currentPage();
                        $start = max(1, $current - $window);
                        $end = min($treatments->lastPage(), $current + $window);
                    @endphp

                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $treatments->url(1) }}">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ $i == $treatments->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $treatments->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if($end < $treatments->lastPage())
                        @if($end < $treatments->lastPage() - 1)
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $treatments->url($treatments->lastPage()) }}">{{ $treatments->lastPage() }}</a>
                        </li>
                    @endif

                    {{-- next --}}
                    @if ($treatments->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $treatments->nextPageUrl() }}" rel="next">Next &raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">Next &raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

    @endif
</div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips after DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(t => new bootstrap.Tooltip(t));
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>All Treatments</h1>

            <div class="mb-3">
                <a href="{{ route('treatments.create') }}" class="btn btn-primary">Create New Treatment</a>
            </div>

            @if($treatments->isEmpty())
                <div class="alert alert-info">
                    No treatments found.
                </div>
            @else
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Wine Row ID</th>
                        <th class="text-center">Planned Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($treatments as $treatment)
                        <tr>
                            <td class="text-center">{{ $treatment->id_treatment }}</td>
                            <td class="text-center">
                                {{ $treatment->type }}
                                @if($treatment->notes)
                                    <i class="fas fa-question-circle text-secondary ms-1" 
                                    data-bs-toggle="tooltip" 
                                    title="{{ $treatment->notes }}" 
                                    style="cursor: help;"></i>
                                @endif
                            </td>

                            <td class="text-center">{{ $treatment->wine_row }}</td>
                            <td class="text-center">{{ $treatment->planned_date ? \Carbon\Carbon::parse($treatment->planned_date)->format('d.m.Y') : 'N/A' }}</td>
                            <td class="text-center">{{ $treatment->is_completed ? 'Completed' : 'Planned' }}</td>
                            <td class="text-center">
                                <a href="{{ route('treatments.edit', $treatment) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('treatments.destroy', $treatment) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                </table>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(t => new bootstrap.Tooltip(t));
</script>
@endsection

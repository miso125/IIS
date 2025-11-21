@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>All Treatments</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

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
                            <th>ID</th>
                            <th>Type</th>
                            <th>Wine Row ID</th>
                            <th>Planned Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatments as $treatment)
                            <tr>
                                <td>{{ $treatment->id_treatment }}</td>
                                <td>{{ $treatment->type }}</td>
                                <td>{{ $treatment->wine_row }}</td>
                                <td>{{ $treatment->planned_date ? \Carbon\Carbon::parse($treatment->planned_date)->format('d.m.Y') : 'N/A' }}</td>
                                <td>{{ $treatment->is_completed ? 'Completed' : 'Planned' }}</td>
                                <td>
                                    <a href="{{ route('treatments.show', $treatment) }}" class="btn btn-info btn-sm">View</a>
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

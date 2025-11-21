@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Users Management</h2>
        </div>
        <div class="col-md-4 text-end">
            @can('create user')
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Name</th>
                        <th>Role</th> <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge bg-info">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->date_of_registration->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
@endsection

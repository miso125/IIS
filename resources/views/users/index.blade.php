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
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->login }}</strong></td>
                            <td>{{ $user->mail }}</td>
                            <td>{{ $user->meno }} {{ $user->prijmeni }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $user->roles->first()->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($user->isActive)
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Active</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->date_of_registration->format('d.m.Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @can('view user')
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can('edit user')
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete user')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - Winery Management')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-1">
                <i class="fas fa-dashboard"></i> Welcome, {{ auth()->user()->name }}!
            </h1>
            <p class="text-muted">You are logged in as <strong>{{ auth()->user()->roles->first()->name ?? 'User' }}</strong></p>
        </div>
    </div>

    <!-- Admin Dashboard -->
    @role('admin')
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <h2 style="color: var(--primary-color);">
                            <i class="fas fa-users"></i> {{ $totalUsers ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Active Users</h5>
                        <h2 style="color: #28a745;">
                            <i class="fas fa-check-circle"></i> {{ $activeUsers ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Vineyards</h5>
                        <h2 style="color: #17a2b8;">
                            <i class="fas fa-leaf"></i> {{ $totalVineyards ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Harvests</h5>
                        <h2 style="color: #ffc107;">
                            <i class="fas fa-apple-alt"></i> {{ $totalHarvests ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Recent Users</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Login</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers ?? [] as $user)
                                    <tr>
                                        <td><strong>{{ $user->login }}</strong></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $user->roles->first()->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('users.index') }}" class="btn btn-dark btn-lg">
                    <i class="fas fa-users-cog"></i> Manage All Users
                </a>
            </div>
        </div>
    @endrole

    <!-- Vinar Dashboard -->
    @role('winemaker')
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">My Vineyards</h5>
                        <h2 style="color: var(--primary-color);">
                            <i class="fas fa-leaf"></i> {{ $myVineyards ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Harvests</h5>
                        <h2 style="color: #ffc107;">
                            <i class="fas fa-apple-alt"></i> {{ $totalHarvests ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Wine Batches</h5>
                        <h2 style="color: #8B0000;">
                            <i class="fas fa-wine-glass"></i> {{ $totalBatches ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Treatments</h5>
                        <h2 style="color: #17a2b8;">
                            <i class="fas fa-spray-can"></i> {{ $totalTreatments ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('vineyards.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Add New Vineyard
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-clock"></i> Recent Harvests</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>Manage harvest records and bottle wine.</p>
                        <a href="{{ route('harvests.index') }}" class="btn btn-warning">
                            Go to Harvests
                        </a>
                        <a href="{{ route('harvests.create') }}" class="btn btn-outline-dark ms-2">
                            Plan New Harvest
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-spray-can"></i> Treatments</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>Track vineyard treatments.</p>
                        <a href="{{ route('treatments.index') }}" class="btn btn-info text-white">
                            View Treatments
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- V sekcii @role('winemaker') --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-wine-bottle"></i> Ready for Bottling</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date Harvested</th>
                                    <th>Variety</th>
                                    <th>Weight</th>
                                    <th>Sugar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($readyToBottle ?? [] as $harvest)
                                    <tr>
                                        <td>{{ $harvest->date_time->format('d.m.Y') }}</td>
                                        <td>{{ $harvest->variety }}</td>
                                        <td>{{ $harvest->weight_grapes }} kg</td>
                                        <td>{{ $harvest->sugariness }} °NM</td>
                                        <td>
                                            <a href="{{ route('harvests.bottle.create', $harvest) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-wine-bottle"></i> Bottle This
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No completed harvests waiting.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-leaf"></i> My Vineyards</h5><br>
                        <a href="{{ route('vineyards.index') }}" class="btn btn-sm btn-light text-dark">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Variety</th>
                                    <th>Heads</th>
                                    <th>Planted Year</th>
                                    <th>Color</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myVineyardsList ?? [] as $vineyard)
                                    <tr>
                                        <td><strong>{{ $vineyard->variety }}</strong></td>
                                        <td>{{ $vineyard->number_of_vines }}</td>
                                        <td>{{ $vineyard->planting_year }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $vineyard->colour == 'white' ? '#fff3cd' : '#8B0000' }}; color: #000;">
                                                {{ ucfirst($vineyard->colour) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('vineyards.edit', $vineyard) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No vineyards yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    <!-- Worker Dashboard -->
    @role('worker')
    {{-- V sekcii @role('worker') --}}
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Planned Harvests (To Do)</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vineyard</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Musíme poslať premennú $plannedHarvests z Controlleru --}}
                        @forelse($plannedHarvests ?? [] as $harvest)
                            <tr>
                                <td>{{ $harvest->date_time->format('d.m.Y') }}</td>
                                <td>{{ $harvest->variety ?? 'Unknown' }}</td>
                                <td>
                                    <a href="{{ route('harvests.edit', $harvest) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Complete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3">No pending harvests.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-spray-can"></i> Report Treatment</h5>
                    </div>
                    <div class="card-body">
                        <p>Record a treatment performed on a vineyard.</p>
                        <a href="{{ route('treatments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Treatment
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-apple-alt"></i> Report Harvest</h5>
                    </div>
                    <div class="card-body">
                        <p>Record a harvest from a vineyard.</p>
                        <a href="{{ route('harvests.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> New Harvest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    <!-- Customer Dashboard -->
    @role('customer')
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">My Purchases</h5>
                        <h2 style="color: var(--primary-color);">
                            <i class="fas fa-shopping-cart"></i> {{ $myPurchases ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Spent</h5>
                        <h2 style="color: #28a745;">
                            <i class="fas fa-euro-sign"></i> {{ $totalSpent ?? '0.00' }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Available Wines</h5>
                        <h2 style="color: #17a2b8;">
                            <i class="fas fa-wine-glass"></i> {{ $availableWines ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('wine_batches.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Browse Our Selection
                </a>
            </div>
        </div>
    @endrole
@endsection

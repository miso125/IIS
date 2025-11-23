<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Winery Management System')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #8B0000;
            --secondary-color: #6F4E37;
            --light-bg: #F5F3F0;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff !important;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: #fff;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border-left: 4px solid #fff;
        }
        
        .main-content {
            padding: 30px;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #690000;
            border-color: #690000;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(139, 0, 0, 0.05);
        }
        
        .badge {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        .user-info {
            padding: 15px 20px;
            background-color: rgba(0,0,0,0.1);
            border-top: 1px solid rgba(255,255,255,0.1);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-wine-glass"></i> Winery Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>

                    <!-- Admin Only -->
                    @role('admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                               href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i> Users Management
                            </a>
                        </li>
                    @endrole

                    <!-- Vinar Only -->
                    @role('winemaker')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vineyards.*') ? 'active' : '' }}" 
                               href="{{ route('vineyards.index') }}">
                                <i class="fas fa-leaf"></i> My Vineyards
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('treatments.*') ? 'active' : '' }}" 
                               href="{{ route('treatments.index') }}">
                                <i class="fas fa-spray-can"></i> Treatments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('harvests.*') ? 'active' : '' }}" 
                               href="{{ route('harvests.index') }}">
                                <i class="fas fa-apple-alt"></i> Harvests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('wine_batches.*') ? 'active' : '' }}" 
                               href="{{ route('wine_batches.index') }}">
                                <i class="fas fa-wine-glass"></i> Wine Batches
                            </a>
                        </li>
                    @endrole

                    <!-- Worker -->
                    @role('worker')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('treatments.*') ? 'active' : '' }}" 
                               href="{{ route('treatments.index') }}">
                                <i class="fas fa-spray-can"></i> Treatments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('harvests.*') ? 'active' : '' }}" 
                               href="{{ route('harvests.index') }}">
                                <i class="fas fa-apple-alt"></i> Harvests
                            </a>
                        </li>
                    @endrole

                    <!-- Customer -->
                    @role('customer')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('wine_batches.*') ? 'active' : '' }}" 
                               href="{{ route('wine_batches.index') }}">
                                <i class="fas fa-wine-glass"></i> Browse Wines
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" 
                               href="{{ route('purchases.index') }}">
                                <i class="fas fa-shopping-cart"></i> My Purchases
                            </a>
                        </li>
                    @endrole

                    @auth
                        <div class="user-info mt-4">
                            <small><strong>Current Role:</strong></small><br>
                            <span class="badge bg-info">{{ auth()->user()->roles->first()->name ?? 'User' }}</span>
                        </div>
                    @endauth
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Flash Messages -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Validation Errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>

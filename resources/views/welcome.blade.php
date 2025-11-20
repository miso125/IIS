<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winery Management System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #8B0000;
            --secondary-color: #6F4E37;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .feature-box {
            text-align: center;
            padding: 30px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }

        .feature-box i {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #690000;
            border-color: #690000;
            transform: scale(1.05);
        }

        .features-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-wine-glass"></i> Winery Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn" style="background: none; border: none; cursor: pointer;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1><i class="fas fa-wine-glass"></i> Winery Management System</h1>
            <p>Professional management for your vineyard operations</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-chart-line"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <i class="fas fa-leaf"></i>
                        <h4>Vineyard Management</h4>
                        <p>Manage your vineyard plots with detailed tracking and records</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <i class="fas fa-spray-can"></i>
                        <h4>Treatment Tracking</h4>
                        <p>Record and monitor all vineyard treatments and pesticides</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <i class="fas fa-apple-alt"></i>
                        <h4>Harvest Records</h4>
                        <p>Track harvest dates, yields, and quality metrics</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-box">
                        <i class="fas fa-wine-glass"></i>
                        <h4>Wine Production</h4>
                        <p>Manage wine batches from production to sale</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="mb-4">Ready to Get Started?</h2>
            <p class="mb-4" style="font-size: 1.1rem;">
                Join us today and streamline your vineyard operations
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-user-plus"></i> Create Your Account
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Winery Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

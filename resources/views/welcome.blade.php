<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winery Andrej - Premium Wines</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #8B0000; /* Deep Red */
            --secondary-color: #6F4E37; /* Earthy Brown */
            --light-gold: #f1e1bf;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fafafa;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            font-family: 'Georgia', serif;
        }

        .hero {
            /* Placeholder image for vineyard */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 180px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            font-family: 'Georgia', serif;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 40px;
            font-family: 'Georgia', serif;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background-color: var(--secondary-color);
            margin: 10px auto 0;
        }

        /* Wine Card Styling */
        .wine-card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            background: white;
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .wine-header {
            height: 150px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .wine-icon {
            font-size: 60px;
            color: var(--primary-color);
            opacity: 0.2;
        }

        .wine-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-red { background-color: #f8d7da; color: #842029; }
        .badge-white { background-color: #fff3cd; color: #664d03; }

        .about-section {
            padding: 80px 0;
            background-color: white;
        }

        .wines-section {
            padding: 80px 0;
            background-color: #f9f7f2; /* Very light paper color */
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        footer {
            background-color: #222;
            color: #aaa;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-wine-bottle me-2"></i> Winery Andrej
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#wines">Our Wines</a>
                    </li>
                    <li class="nav-item mx-2">|</li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light px-3" href="{{ route('dashboard') }}">My Account</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-light text-dark px-3 fw-bold" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>Taste the Tradition</h1>
            <p>Handcrafted wines from the heart of our family vineyards.</p>
            <a href="#wines" class="btn btn-outline-light btn-lg mt-3 px-5">
                View Our Collection
            </a>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="https://images.unsplash.com/photo-1528823872057-9c018a7a7553?q=80&w=1000&auto=format&fit=crop" 
                         alt="Winery Cellar" class="img-fluid rounded shadow-lg">
                </div>
                <div class="col-md-6 ps-md-5">
                    <h2 class="section-title text-start">Our Story</h2>
                    <p class="lead text-muted">Located in the beautiful region of Modra, Winery Andrej has been producing exceptional wines for generations.</p>
                    <p>
                        We combine traditional winemaking methods with modern technology to bring you wines of distinct character and quality. 
                        Our vineyards are treated with the utmost care, ensuring that every grape harvested contributes to a perfect bottle.
                    </p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <h3 class="text-primary fw-bold">1900+</h3>
                            <p class="small text-muted">Vines Planted</p>
                        </div>
                        <div class="col-6">
                            <h3 class="text-primary fw-bold">100%</h3>
                            <p class="small text-muted">Family Owned</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="wines" class="wines-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Current Selection</h2>
                <p class="text-muted">Explore our available wine batches.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="wine-card">
                        <div class="wine-header">
                            <i class="fas fa-wine-glass-alt wine-icon"></i>
                            <span class="wine-badge badge-white">White</span>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title mb-1">Veltlínske zelené</h4>
                            <p class="text-muted mb-3">Vintage 2024</p>
                            <hr class="w-25 mx-auto my-3">
                            <p class="card-text small">
                                A fresh, aromatic white wine with hints of almond and green apple. Perfect for warm evenings.
                            </p>
                            <ul class="list-inline text-muted small mt-3">
                                <li class="list-inline-item"><i class="fas fa-percentage"></i> 12.5% Alc.</li>
                                <li class="list-inline-item"><i class="fas fa-tint"></i> Dry</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="wine-card">
                        <div class="wine-header">
                            <i class="fas fa-wine-glass wine-icon"></i>
                            <span class="wine-badge badge-red">Red</span>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title mb-1">Frankovka modrá</h4>
                            <p class="text-muted mb-3">Vintage 2024</p>
                            <hr class="w-25 mx-auto my-3">
                            <p class="card-text small">
                                A rich, full-bodied red with distinct berry notes and a smooth finish. Aged in oak barrels.
                            </p>
                            <ul class="list-inline text-muted small mt-3">
                                <li class="list-inline-item"><i class="fas fa-percentage"></i> 13.0% Alc.</li>
                                <li class="list-inline-item"><i class="fas fa-tint"></i> Dry</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="wine-card">
                        <div class="wine-header">
                            <i class="fas fa-wine-glass-alt wine-icon"></i>
                            <span class="wine-badge badge-white">White</span>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title mb-1">Riesling</h4>
                            <p class="text-muted mb-3">Vintage 2024</p>
                            <hr class="w-25 mx-auto my-3">
                            <p class="card-text small">
                                Known as the king of wines. High acidity balanced with elegant fruitiness and minerality.
                            </p>
                            <ul class="list-inline text-muted small mt-3">
                                <li class="list-inline-item"><i class="fas fa-percentage"></i> 12.8% Alc.</li>
                                <li class="list-inline-item"><i class="fas fa-tint"></i> Semi-Dry</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted">Want to see pricing and purchase?</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Register to View Prices</a>
                @else
                    <a href="{{ route('wine_batches.index') }}" class="btn btn-primary-custom">Go to Shop</a>
                @endguest
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2 class="mb-3">Join Our Wine Community</h2>
            <p class="mb-4 opacity-75" style="font-size: 1.1rem;">
                Create an account to order wines, track your purchase history, and get exclusive offers.
            </p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 shadow">
                    <i class="fas fa-user-plus me-2"></i> Create Customer Account
                </a>
                <div class="mt-3">
                    <span class="opacity-75">Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-white fw-bold ms-1">Login here</a>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 shadow">
                    Go to Dashboard
                </a>
            @endguest
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Winery Andrej</h5>
                    <p class="small">Bringing the tradition of honest winemaking to your table since 1900.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Contact</h5>
                    <p class="small mb-1"><i class="fas fa-map-marker-alt me-2"></i> Vinohradnícka 5, Modra</p>
                    <p class="small mb-1"><i class="fas fa-envelope me-2"></i> [email protected]</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Opening Hours</h5>
                    <p class="small mb-1">Mon - Fri: 09:00 - 18:00</p>
                    <p class="small">Sat - Sun: 10:00 - 16:00</p>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <p class="mb-0 small">&copy; 2025 Winery Management System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
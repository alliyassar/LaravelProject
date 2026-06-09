<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SHOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #FBFBFC; }
        .top-header { background-color: #1E1F29; color: #B9BABC; font-size: 12px; padding: 7px 0; }
        .top-header a { color: #B9BABC; text-decoration: none; }
        .top-header a:hover { color: #D10024; }
        
        .main-header { background-color: #15161D; padding: 25px 0; border-bottom: 3px solid #D10024; }
        .logo-text { color: #FFFFFF; font-weight: 700; font-size: 34px; text-decoration: none; }
        .logo-text span { color: #D10024; }
        
        .search-btn { background-color: #D10024; color: white; border: none; font-weight: 700; padding: 0 25px; }
        .search-btn:hover { background-color: #a8001c; color: white; }
        
        .navigation-bar { background-color: #FFFFFF; border-bottom: 2px solid #E4E7ED; padding: 15px 0; }
        .category-trigger { background-color: #FF6600; color: white; font-weight: 700; text-transform: uppercase; padding: 10px 20px; border: none; }
        
        .user-dropdown .dropdown-toggle { color: #FFFFFF; text-decoration: none; font-weight: 500; }
        .user-dropdown .dropdown-menu { background-color: #FFFFFF; border-radius: 0; border: 1px solid #E4E7ED; box-shadow: 0px 6px 12px rgba(0,0,0,0.1); }
        
        footer { background-color: #15161D; color: #B9BABC; padding: 60px 0 20px 0; font-size: 14px; margin-top: 50px; }
        footer h3 { color: #FFFFFF; font-weight: 700; font-size: 16px; margin-bottom: 25px; text-transform: uppercase; border-bottom: 2px solid #D10024; padding-bottom: 10px; display: inline-block; }
        footer a { color: #B9BABC; text-decoration: none; }
        footer a:hover { color: #D10024; }
    </style>
</head>
<body>

    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div>Welcome to E-shop!</div>
            <div class="d-flex gap-3">
                <a href="#">STORE</a>
                <a href="#">NEWSLETTER</a>
                <a href="#">FAQ</a>
                <span class="text-muted">ENG <i class="fa fa-caret-down"></i></span>
                <span class="text-muted">USD <i class="fa fa-caret-down"></i></span>
            </div>
        </div>
    </div>

    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <a href="{{ route('home') }}" class="logo-text">E-<span>SHOP</span></a>
                </div>
                
                <div class="col-md-6 mb-3 mb-md-0">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="input-group">
                            <select name="category" class="form-select border-0 bg-white" style="max-width: 150px;">
                                <option value="">All Categories</option>
                                <option value="1">Laptops</option>
                                <option value="2">Smartphones</option>
                                <option value="3">Cameras</option>
                            </select>
                            <input type="text" name="search" class="form-control border-0" placeholder="Enter your keyword" value="{{ request('search') }}">
                            <button class="btn search-btn" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                
                <div class="col-md-3 d-flex justify-content-end align-items-center gap-4">
                    <div class="dropdown user-dropdown">
                        @auth
                            <a class="dropdown-toggle text-white text-decoration-none fw-bold small text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user me-2 text-white"></i>{{ auth()->user()->name }} <br><span class="text-muted" style="font-size: 10px; font-weight: normal;">WELCOME</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3" style="min-width: 200px; z-index: 9999;">
                                <li class="mb-2"><a href="{{ route('my.orders') }}" class="dropdown-item fw-bold text-danger"><i class="fa-solid fa-box me-2"></i>MY ORDERS</a></li>
                                <li class="mb-2"><a href="{{ route('cart.index') }}" class="dropdown-item"><i class="fa-solid fa-shopping-cart me-2"></i>MY CART</a></li>
                                <li class="mb-2"><a href="{{ route('checkout') }}" class="dropdown-item"><i class="fa-solid fa-credit-card me-2"></i>CHECKOUT</a></li>
                                <li class="border-top pt-2 mt-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-dark w-100 fw-bold">LOGOUT</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <a class="dropdown-toggle text-white text-decoration-none fw-bold small" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user me-2"></i>ACCOUNT <br><span class="text-muted" style="font-size: 10px; font-weight: normal;">Sign In / Up</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2">
                                <li><a class="dropdown-item fw-bold" href="{{ route('login') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                            </ul>
                        @endauth
                    </div>

                    <a href="{{ route('cart.index') }}" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fa-solid fa-shopping-cart fs-4"></i>
                        <span class="text-uppercase ms-2 d-none d-lg-inline small fw-bold" style="font-size: 11px;">My Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation-bar mb-4">
        <div class="container d-flex align-items-center gap-3">
            <div class="dropdown">
                <button class="category-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bars me-2"></i> Categories
                </button>
                <ul class="dropdown-menu rounded-0 shadow-sm border-0 mt-2" style="background-color: #15161D; min-width: 200px; border-top: 3px solid #D10024;">
                    <li><a class="dropdown-item text-white py-2 small fw-bold border-bottom border-secondary" href="{{ route('home') }}">ALL CATEGORIES</a></li>
                    <li><a class="dropdown-item text-white py-2 small text-uppercase" href="{{ route('home', ['category' => 1]) }}"><i class="fa-solid fa-angle-right me-2 text-danger"></i>LAPTOPS</a></li>
                    <li><a class="dropdown-item text-white py-2 small text-uppercase" href="{{ route('home', ['category' => 2]) }}"><i class="fa-solid fa-angle-right me-2 text-danger"></i>SMARTPHONES</a></li>
                    <li><a class="dropdown-item text-white py-2 small text-uppercase" href="{{ route('home', ['category' => 3]) }}"><i class="fa-solid fa-angle-right me-2 text-danger"></i>CAMERAS</a></li>
                </ul>
            </div>

            <nav class="d-flex gap-4 fw-bold small">
                <a href="{{ route('home') }}" class="text-danger text-decoration-none">HOME</a>
                <a href="{{ route('home', ['category' => 1]) }}" class="text-dark text-decoration-none">LAPTOPS</a>
                <a href="{{ route('home', ['category' => 2]) }}" class="text-dark text-decoration-none">SMARTPHONES</a>
                <a href="{{ route('home', ['category' => 3]) }}" class="text-dark text-decoration-none">CAMERAS</a>
            </nav>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3>E-SHOP</h3>
                    <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><i class="fa fa-map-marker text-danger me-2"></i> Nisantasi unv kampus room 5</li>
                        <li><i class="fa fa-phone text-danger me-2"></i> +212-00-00-00</li>
                        <li><i class="fa fa-envelope text-danger me-2"></i> yuksel.celik@nisantasi.edu.tr</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Customer Service</h3>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Shipping & Return</a></li>
                        <li><a href="#">Shipping Guide</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h3>Stay Connected</h3>
                    <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
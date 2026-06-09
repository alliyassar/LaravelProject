@php
 use App\Models\Cart;
 $headerCartItems = collect();
 $headerCartCount = 0;
 $headerCartTotal = 0;
 if (auth()->check()) {
     $headerCartItems = Cart::with('product')
         ->where('user_id', auth()->id())
         ->get();
     $headerCartCount = $headerCartItems->sum('quantity');
     $headerCartTotal = $headerCartItems->sum(function ($item) {
         return $item->price * $item->quantity;
     });
 }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NovaStore E-Commerce')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .dropdown-list { display: none; position: absolute; background: white; list-style: none; padding: 10px; border: 1px solid #ddd; z-index: 1000; right: 0; min-width: 160px; }
        .user-hover:hover .dropdown-list { display: block; }
        .minicart-wrap { position: relative; }
        .cart-list-wrapper { display: none; position: absolute; background: white; border: 1px solid #ddd; width: 300px; right: 0; z-index: 1000; padding: 15px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); }
        .minicart-wrap:hover .cart-list-wrapper { display: block; }
        .cart-list { list-style: none; padding: 0; max-height: 200px; overflow-y: auto; }
        .cart-list li { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .nav-link { color: #333; font-weight: 500; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">NovaStore</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="catDrop" role="button" data-bs-toggle="dropdown">Categories</a>
                    <ul class="dropdown-menu">
                        @forelse($categories as $cat)
                            <li><a class="dropdown-menu-item p-2 d-block text-dark text-decoration-none" href="#">{{ $cat->title }}</a></li>
                        @empty
                            <li><a class="dropdown-menu-item p-2 d-block text-muted" href="#">No Categories</a></li>
                        @endforelse
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}">Admin Panel</a></li>
            </ul>

            <div class="header-configure-area">
                <ul class="nav align-items-center">
                    
                    <li class="user-hover position-relative me-4">
                        <a href="#" class="text-decoration-none text-dark fw-bold">
                            <i class="fa-regular fa-user me-1"></i>
                            @auth
                                {{ auth()->user()->name }} 
                            @else
                                My Account 
                            @endauth
                        </a>
                        <ul class="dropdown-list shadow rounded">
                            @auth
                                <li class="mb-2"><a href="#" class="text-decoration-none text-dark d-block">My Account</a></li>
                                <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-decoration-none text-dark d-block">My Cart</a></li>
                                <li class="mb-2"><a href="{{ route('checkout') }}" class="text-decoration-none text-dark d-block">Checkout</a></li>
                                <li class="border-top pt-2">
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Logout</button>
                                    </form>
                                </li>
                            @else
                                <li class="mb-2"><a href="{{ url('/login') }}" class="btn btn-sm btn-primary w-100">Login</a></li>
                                <li><a href="{{ url('/register') }}" class="text-decoration-none text-muted small d-block text-center">Join / Register</a></li>
                            @endauth
                        </ul>
                    </li>
                    
                    <li class="minicart-wrap">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-dark btn-sm position-relative">
                            <i class="fa-solid fa-bag-shopping me-1"></i> My Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $headerCartCount }}
                            </span>
                        </a>
                        <div class="cart-list-wrapper shadow rounded">
                            <h6 class="border-bottom pb-2 fw-bold">Mini Cart</h6>
                            <ul class="cart-list">
                                @auth
                                    @forelse($headerCartItems as $item)
                                        <li>
                                            <div class="cart-info">
                                                <h6 class="mb-0 fw-bold" style="font-size: 14px;">{{ $item->product->title ?? 'Product Deleted' }}</h6>
                                                <small class="text-muted">${{ number_format($item->price, 2) }} x{{ $item->quantity }}</small>
                                            </div>
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn p-0 text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="p-2 text-muted text-center">Your cart is empty.</li>
                                    @endforelse
                                @else
                                    <li class="p-2 text-muted text-center">Please login to view cart.</li>
                                @endauth
                            </ul>
                            <div class="cart-price-total d-flex justify-content-between my-2 border-top pt-2">
                                <span>Subtotal:</span>
                                <strong class="text-success">${{ number_format($headerCartTotal, 2) }}</strong>
                            </div>
                            <div class="d-grid gap-2 mt-2">
                                <a href="{{ route('cart.index') }}" class="btn btn-sm btn-dark">View Cart</a>
                                <a href="{{ route('checkout') }}" class="btn btn-sm btn-primary">Checkout</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
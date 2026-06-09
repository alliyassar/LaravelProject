@extends('welcome')

@section('content')
<div class="container mt-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-0 mb-4" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismissible="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-0 mb-4" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismissible="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 rounded-0 shadow-sm p-4 bg-white">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="text-center p-3 border mb-3 bg-white" style="height: 400px; display: flex; align-items: center; justify-content: center; border-color: #E4E7ED !important;">
                    @php
                        $detailImg = 'images/' . trim($product->name) . '.webp';
                    @endphp
                    <img src="{{ asset($detailImg) }}" class="img-fluid" style="max-height: 360px; object-fit: contain;" alt="Product Image" onerror="this.src='{{ asset('images/Asus ROG Strix Laptop.webp') }}'">
                </div>
            </div>
            
            <div class="col-md-6">
                <h2 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 24px;">{{ $product->name }}</h2>
                <div class="mb-4">
                    <span class="fs-3 fw-bold" style="color: #D10024;">${{ number_format($product->price, 2) }}</span>
                </div>
                <p class="text-muted small lh-lg mb-4">{{ $product->description }}</p>
                <hr style="color: #E4E7ED;">
                
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                    @csrf
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3" style="width: 100px;">
                            <label class="small text-uppercase fw-bold text-secondary mb-1 d-block">Miktar (QTY):</label>
                            <input type="number" name="quantity" class="form-control rounded-0 text-center" value="1" min="1" style="height: 40px;">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn text-white fw-bold rounded-0 px-5 text-uppercase" style="background-color: #D10024; height: 45px; border: none; letter-spacing: 1px;">
                        <i class="fa fa-shopping-cart me-2"></i> Add To Cart
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
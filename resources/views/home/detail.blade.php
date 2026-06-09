@extends('welcome')

@section('content')
<div class="container mt-5">
    <div class="card border-0 rounded-0 shadow-sm p-4 bg-white">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="text-center p-3 border mb-3 bg-white" style="height: 400px; display: flex; align-items: center; justify-content: center; border-color: #E4E7ED !important;">
                    @php
                        // Veritabanındaki ismi hiç bozmadan, boşlukları koruyarak uzantı ekliyoruz
                        // Örn: "Asus ROG Strix Laptop" -> "images/Asus ROG Strix Laptop.webp" arar.
                        $detailImg = 'images/' . trim($product->name) . '.webp';
                    @endphp
                    <img src="{{ asset($detailImg) }}" class="img-fluid" style="max-height: 360px; object-fit: contain;" alt="Product Image" onerror="this.src='{{ asset('images/Asus ROG Strix Laptop.webp') }}'">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 24px;">{{ $product->name }}</h2>
                <div class="mb-4"><span class="fs-3 fw-bold" style="color: #D10024;">${{ number_format($product->price, 2) }}</span></div>
                <p class="text-muted small lh-lg mb-4">{{ $product->description }}</p>
                <hr style="color: #E4E7ED;">
                <button class="btn text-white fw-bold rounded-0 px-4 text-uppercase" style="background-color: #D10024; height: 40px; border: none;">Add To Cart</button>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('welcome')

@section('content')
<div class="container">
    
    <div class="card border-0 rounded-0 mb-5 text-white overflow-hidden shadow-sm" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1547949003-9792a18a2601?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div class="text-center p-4">
            <span class="badge bg-danger mb-2 px-3 py-2 text-uppercase fw-bold" style="letter-spacing: 2px;">Hot Deal This Week</span>
            <h1 class="display-3 fw-bold text-uppercase mb-2" style="letter-spacing: 3px;">BAGS SALE</h1>
            <p class="fs-4 text-uppercase fw-medium mb-4">Up to 50% Discount</p>
            <a href="#" class="btn btn-danger btn-lg fw-bold px-5 py-3 rounded-0 text-uppercase" style="background-color: #D10024; border: none; font-size: 14px; letter-spacing: 1px;">Shop Now</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header text-white fw-bold uppercase rounded-0" style="background-color: #1E1F29; padding: 12px 15px;">
                    <i class="fa-solid fa-filter me-2"></i>Filter Products
                </div>
                <div class="card-body">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-secondary">Category</label>
                            <select name="category" class="form-select rounded-0">
                                <option value="">All Categories</option>
                                <option value="1" {{ request('category') == '1' ? 'selected' : '' }}>Laptops</option>
                                <option value="2" {{ request('category') == '2' ? 'selected' : '' }}>Smartphones</option>
                                <option value="3" {{ request('category') == '3' ? 'selected' : '' }}>Cameras</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-secondary">Price Range ($)</label>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text rounded-0">Min</span>
                                <input type="number" name="min_price" class="form-control rounded-0" value="{{ request('min_price') }}" placeholder="0">
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text rounded-0">Max</span>
                                <input type="number" name="max_price" class="form-control rounded-0" value="{{ request('max_price') }}" placeholder="9999">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-dark btn-sm fw-bold rounded-0 py-2 text-uppercase" style="letter-spacing: 1px;">Apply Filters</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm rounded-0 text-uppercase" style="font-size: 12px;">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h4 class="mb-4 fw-bold text-uppercase text-dark border-bottom pb-2" style="font-size: 18px; letter-spacing: 1px;">Our Products</h4>
            
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm border-1 rounded-0 position-relative" style="border-color: #E4E7ED;">
                            <span class="position-absolute top-0 start-0 badge bg-danger m-2 rounded-0 text-uppercase small" style="font-size: 10px; z-index: 2;">Product</span>
                            
                            <div class="text-center py-3 bg-white" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                                @php
                                    // Veritabanındaki ürün adını hiç bozmadan, boşlukları ve büyük harfleri koruyarak uzantı ekliyoruz
                                    // Örn: "Asus ROG Strix Laptop" -> "images/Asus ROG Strix Laptop.webp" arar.
                                    $finalImgPath = 'images/' . trim($product->name) . '.webp';
                                @endphp
                                <img src="{{ asset($finalImgPath) }}" class="img-fluid" style="max-height: 150px; max-width: 90%; object-fit: contain;" alt="Product Image" onerror="this.src='{{ asset('images/Asus ROG Strix Laptop.webp') }}'">
                            </div>

                            <div class="card-body d-flex flex-column text-center border-top p-3" style="background-color: #FFF;">
                                <h5 class="card-title fw-bold text-uppercase mb-2 text-truncate" style="font-size: 14px;">
                                    <a href="{{ route('product.detail', $product->id) }}" class="text-dark text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                
                                <div class="mb-3">
                                    <span class="fs-5 fw-bold" style="color: #D10024;">${{ number_format($product->price, 2) }}</span>
                                </div>
                                
                                <div class="d-grid mt-auto">
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-dark btn-sm fw-bold rounded-0 text-uppercase" style="font-size: 11px; letter-spacing: 1px;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fa-solid fa-face-frown fa-3x text-muted mb-3"></i>
                        <p class="text-muted fs-5">No products found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                @if(method_exists($products, 'links'))
                    {{ $products->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
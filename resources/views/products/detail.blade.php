@extends('welcome')

@section('title') E-SHOP - Product Detail @endsection

@section('content')
@php
    // Gelen veri bir koleksiyon ise içindeki ilk gerçek ürünü izole ediyoruz
    if (isset($product) && is_object($product) && method_exists($product, 'first') && !($product instanceof \App\Models\Product)) {
        $singleProduct = $product->first();
    } else {
        $singleProduct = $product ?? null;
    }

    // Değerlerin güvenli kontrolü için varsayılan atamalar
    $productName = $singleProduct->name ?? 'E-Shop Product';
    $productPrice = $singleProduct->price ?? 0.00;
    $productDesc = $singleProduct->description ?? 'No product description available in the database.';
    $productId = $singleProduct->id ?? 1;
@endphp

<div class="container mt-5">
    <div class="card border-0 rounded-0 shadow-sm p-4 bg-white">
        <div class="row">
            
            <div class="col-md-6 mb-4">
                <div class="text-center p-3 border mb-3 bg-white" style="height: 400px; display: flex; align-items: center; justify-content: center; border-color: #E4E7ED !important;">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=500&q=80" class="img-fluid" style="max-height: 360px; object-fit: contain;" alt="Product Main Image">
                </div>
                
                <div class="d-flex justify-content-center gap-2 overflow-hidden">
                    <div class="border p-2 active" style="width: 80px; height: 80px; border-color: #FF6600 !important; cursor: pointer;">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=70&q=80" class="img-fluid" alt="thumb">
                    </div>
                    <div class="border p-2" style="width: 80px; height: 80px; border-color: #E4E7ED; cursor: pointer; opacity: 0.5;">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=70&q=80" class="img-fluid" style="filter: hue-rotate(90deg);" alt="thumb">
                    </div>
                    <div class="border p-2" style="width: 80px; height: 80px; border-color: #E4E7ED; cursor: pointer; opacity: 0.5;">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=70&q=80" class="img-fluid" style="filter: hue-rotate(180deg);" alt="thumb">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex gap-2 mb-2">
                    <span class="badge bg-dark rounded-0 text-uppercase px-3 py-1 fw-bold" style="font-size: 11px;">New</span>
                    <span class="badge bg-danger rounded-0 text-uppercase px-3 py-1 fw-bold" style="font-size: 11px; background-color: #FF6600 !important;">-20%</span>
                </div>

                <h2 class="fw-bold text-uppercase text-dark mb-2" style="font-size: 24px; letter-spacing: 0.5px;">
                    {{ $productName }}
                </h2>

                <div class="d-flex align-items-center gap-2 mb-3 text-warning small">
                    <div>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa-regular fa-star text-muted"></i>
                    </div>
                    <span class="text-muted small" style="font-size: 12px;">3 Review(s) / Add Review</span>
                </div>

                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <span class="fs-3 fw-bold text-dark">${{ number_format($productPrice, 2) }}</span>
                    <span class="text-muted text-decoration-line-through small" style="font-size: 14px;">
                        ${{ number_format($productPrice * 1.25, 2) }}
                    </span>
                </div>

                <div class="small mb-4 d-flex flex-column gap-1 text-uppercase fw-bold text-secondary" style="font-size: 12px;">
                    <div>Availability: <span class="text-success">In Stock</span></div>
                    <div>Brand: <span class="text-dark">E-SHOP</span></div>
                </div>

                <p class="text-muted small lh-lg mb-4">
                    {{ $productDesc }}
                </p>

                <hr style="color: #E4E7ED;">

                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="text-uppercase fw-bold text-dark small" style="min-width: 60px; font-size: 12px;">Size:</span>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-danger rounded-0 fw-bold px-3" style="color: #FF6600; border-color: #FF6600; font-size: 11px;">S</button>
                        <button class="btn btn-sm btn-outline-secondary rounded-0 fw-bold px-3 text-dark" style="border-color: #E4E7ED; font-size: 11px;">XL</button>
                        <button class="btn btn-sm btn-outline-secondary rounded-0 fw-bold px-3 text-dark" style="border-color: #E4E7ED; font-size: 11px;">SL</button>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="text-uppercase fw-bold text-dark small" style="min-width: 60px; font-size: 12px;">Color:</span>
                    <div class="d-flex gap-2">
                        <span class="d-inline-block rounded-0 border border-dark" style="width: 20px; height: 20px; background-color: #3B5998; cursor: pointer; outline: 2px solid #FF6600;"></span>
                        <span class="d-inline-block rounded-0 border" style="width: 20px; height: 20px; background-color: #A62B4E; cursor: pointer; border-color: #E4E7ED;"></span>
                        <span class="d-inline-block rounded-0 border" style="width: 20px; height: 20px; background-color: #F7941D; cursor: pointer; border-color: #E4E7ED;"></span>
                    </div>
                </div>

                <hr style="color: #E4E7ED;">

                <form action="{{ route('cart.index') }}" method="GET">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <span class="text-uppercase fw-bold text-dark small me-3" style="font-size: 12px;">QTY:</span>
                            <input type="number" name="quantity" class="form-control text-center rounded-0 fw-bold" value="1" min="1" style="width: 70px; height: 40px; border-color: #E4E7ED;">
                        </div>
                        
                        <button type="submit" class="btn text-white fw-bold rounded-0 px-4 text-uppercase d-flex align-items-center gap-2" style="background-color: #FF6600; height: 40px; font-size: 13px; letter-spacing: 0.5px; border: none;">
                            <i class="fa fa-shopping-cart"></i> Add To Cart
                        </button>
                        
                        <div class="d-flex gap-1 ms-md-2">
                            <button type="button" class="btn btn-light rounded-0 border" style="height: 40px; width: 40px; border-color: #E4E7ED;"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        
        <div class="row mt-5 pt-4 border-top" style="border-color: #E4E7ED !important;">
            <div class="col-12">
                <ul class="nav nav-tabs rounded-0 border-0 d-flex gap-4 mb-4" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-0 border-0 fw-bold p-0 text-uppercase pb-2" style="color: #FF6600; border-bottom: 2px solid #FF6600 !important; font-size: 13px;" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-0 border-0 fw-bold p-0 text-muted text-uppercase pb-2" style="font-size: 13px;" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews (3)</button>
                    </li>
                </ul>
                <div class="tab-content text-muted small lh-lg" id="productTabContent">
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        {{ $productDesc }}
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <p class="fw-bold text-dark">User Reviews:</p>
                        <div class="border-bottom pb-2 mb-2">
                            <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                            <strong class="ms-2 text-dark">Hakan T.</strong> - <span class="text-muted small">06/04/2026</span>
                            <p class="mb-0 text-secondary">Maddi açıdan çok iyi, projedeki isterleri tam anlamıyla karşılıyor.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
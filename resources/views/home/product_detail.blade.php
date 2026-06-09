@extends('welcome')

@section('title') {{ $product->title }} - Details @endsection

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded p-4 bg-white mb-4">
        <div class="row">
            <div class="col-md-6 text-center bg-light rounded d-flex align-items-center justify-content-center" style="min-height: 300px;">
                <i class="fa-solid fa-box-open fa-6x text-secondary"></i>
            </div>
            <div class="col-md-6 ps-md-5 mt-4 mt-md-0 d-flex flex-column justify-content-between">
                <div>
                    <span class="badge bg-primary px-3 py-2 mb-2">{{ $product->category->title ?? 'General' }}</span>
                    <h2 class="fw-bold text-dark mb-2">{{ $product->title }}</h2>
                    <div class="fs-3 fw-bold text-success mb-4">${{ number_format($product->price, 2) }}</div>
                    <h5 class="fw-bold text-secondary">Product Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>

                <div class="border-top pt-4 mt-4">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-sm-0">
                                <label class="form-label small fw-bold text-uppercase text-muted">Quantity</label>
                                <input type="number" name="quantity" class="form-control text-center fw-bold" value="1" min="1" required>
                            </div>
                            <div class="col-md-8 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold"><i class="fa-solid fa-cart-plus me-2"></i>Add to Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="fa-regular fa-comments me-2"></i>Customer Reviews ({{ $product->reviews->count() }})
                </div>
                <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                    @forelse($product->reviews as $rev)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-primary"><i class="fa-regular fa-user me-1"></i>{{ $rev->user->name }}</strong>
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rev->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                    @endfor
                                </span>
                            </div>
                            <p class="text-muted small mb-1">{{ $rev->comment }}</p>
                            <small class="text-muted" style="font-size: 11px;">{{ $rev->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-comment-slash fa-2x mb-2"></i>
                            <p class="mb-0">No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Write a Review
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('product.review.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Your Rating</label>
                                <select name="rating" class="form-select" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 - Excellent)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 - Very Good)</option>
                                    <option value="3">⭐⭐⭐ (3 - Good)</option>
                                    <option value="2">⭐⭐ (2 - Fair)</option>
                                    <option value="1">⭐ (1 - Poor)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Your Comment</label>
                                <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this product..." required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">Submit Review</button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-4 bg-light rounded border">
                            <p class="text-muted small mb-3">You must be logged in to post a review.</p>
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary fw-bold">Sign In Here</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@extends('layouts.home')

@section('title')
    Checkout
@endsection

@section('content')
<div class="container mt-5">
    <div class="breadcrumbs mb-4">
        <a href="{{ route('home') }}">Home</a> / <span>Checkout</span>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('place.order') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">BILLING DETAILS</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">SHIPPING & PAYMENT METHODS</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold">SHIPPING METHODS</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="shipping_method" id="ship1" value="Free Shipping" checked>
                            <label class="form-check-input-label" for="ship1">Free Shipping - $0.00</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="shipping_method" id="ship2" value="Standard Shipping">
                            <label class="form-check-input-label" for="ship2">Standard Shipping - $4.00</label>
                        </div>

                        <h6 class="fw-bold">PAYMENT METHODS</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay1" value="Direct Bank Transfer" checked>
                            <label class="form-check-input-label" for="pay1">Direct Bank Transfer</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay2" value="Cash on Delivery">
                            <label class="form-check-input-label" for="pay2">Cash on Delivery</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay3" value="Paypal">
                            <label class="form-check-input-label" for="pay3">Paypal</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">ORDER REVIEW</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless align-middle">
                            <thead>
                                <tr class="border-bottom">
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr class="border-bottom">
                                        <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="bg-light p-3 rounded mt-3">
                            <p class="d-flex justify-content-between mb-2"><span>SUBTOTAL</span> <span>${{ number_format($subtotal, 2) }}</span></p>
                            <p class="d-flex justify-content-between mb-2"><span>SHIPPING</span> <span class="text-muted">Calculated on select</span></p>
                            <h5 class="d-flex justify-content-between border-top pt-2 mt-2"><span>TOTAL</span> <span class="text-success">${{ number_format($total, 2) }}</span></h5>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold text-dark mt-4 py-2">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
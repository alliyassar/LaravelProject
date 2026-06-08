@extends('layouts.home')

@section('title')
    My Cart
@endsection

@section('content')
<div class="container mt-5">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a> / <span>My Cart</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <div class="card shadow mt-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">My Cart</h4>
        </div>
        <div class="card-body">
            @if($cartItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach($cartItems as $item)
                                @php
                                    $lineTotal = $item->price * $item->quantity;
                                    $subtotal += $lineTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="me-2">
                                            @endif
                                            <span class="fw-bold">{{ $item->product->name ?? 'Product Deleted' }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width: 70px;">
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold">${{ number_format($lineTotal, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="border p-3 rounded bg-light">
                            <p class="d-flex justify-content-between"><span>SUBTOTAL:</span> <strong>${{ number_format($subtotal, 2) }}</strong></p>
                            <p class="d-flex justify-content-between"><span>TOTAL:</span> <strong class="text-success">${{ number_format($subtotal, 2) }}</strong></p>
                            <hr>
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100 fw-bold">Checkout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-5">Your cart is empty.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
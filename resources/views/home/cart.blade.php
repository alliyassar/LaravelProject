@extends('welcome')

@section('title') My Cart @endsection

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fa-solid fa-cart-shopping me-2"></i>My Cart</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($cartItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th class="text-center">Action</th>
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
                                    <td class="fw-bold">{{ $item->product->title ?? 'Product Deleted' }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center" style="max-width: 150px;">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm me-2">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                        </form>
                                    </td>
                                    <td class="fw-bold text-dark">${{ number_format($lineTotal, 2) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i> Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded border shadow-sm">
                            <p class="d-flex justify-content-between mb-2"><span>SUBTOTAL</span> <span>${{ number_format($subtotal, 2) }}</span></p>
                            <h5 class="d-flex justify-content-between border-top pt-2 mt-2 text-success"><span>TOTAL</span> <strong>${{ number_format($subtotal, 2) }}</strong></h5>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('checkout') }}" class="btn btn-primary"><i class="fa-solid fa-credit-card me-2"></i>Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-basket-shopping text-muted mb-3" style="font-size: 48px;"></i>
                    <p class="text-muted fs-5">Your cart is empty.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-sm">Continue Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
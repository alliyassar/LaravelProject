@extends('welcome')

@section('title') Checkout @endsection

@section('content')
<div class="container">
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

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fa-solid fa-cash-register me-2"></i>Checkout</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('place.order') }}" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="col-md-7">
                        <h5 class="mb-3 text-primary border-bottom pb-2">Billing Details</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="+90 5xx xxx xx xx">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Street, Neighborhood, No..." required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">City</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Country</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control">
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Shipping Methods</h5>
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method" id="ship1" value="Free Shipping" checked>
                                <label class="form-check-label fw-bold" for="ship1">Free Shipping - $0.00</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping_method" id="ship2" value="Standard Shipping">
                                <label class="form-check-label fw-bold" for="ship2">Standard Shipping - $4.00</label>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Payment Methods</h5>
                        <div class="p-3 bg-light rounded border">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay1" value="Direct Bank Transfer" checked>
                                <label class="form-check-label fw-bold" for="pay1">Direct Bank Transfer</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay2" value="Cash on Delivery">
                                <label class="form-check-label fw-bold" for="pay2">Cash on Delivery</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="pay3" value="Paypal">
                                <label class="form-check-label fw-bold" for="pay3">Paypal</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 mt-4 mt-md-0">
                        <h5 class="mb-3 text-primary border-bottom pb-2">Order Review</h5>
                        <div class="p-3 bg-dark text-white rounded shadow-sm">
                            <table class="table table-sm table-dark table-borderless align-middle mb-0">
                                <thead>
                                    <tr class="border-bottom text-muted">
                                        <th>Product</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td style="font-size: 14px;">
                                                {{ $item->product->title ?? 'Product Deleted' }} 
                                                <span class="text-warning">x{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-top" style="height: 40px;">
                                        <td>Subtotal</td>
                                        <td class="text-end fw-bold text-info">${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-end text-muted" style="font-size: 13px;">Free / Standard</td>
                                    </tr>
                                    <tr class="border-top" style="height: 50px;">
                                        <td class="fs-5 fw-bold text-warning">TOTAL</td>
                                        <td class="text-end fs-5 fw-bold text-success">${{ number_format($total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg fw-bold"><i class="fa-solid fa-circle-check me-2"></i>Place Order</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
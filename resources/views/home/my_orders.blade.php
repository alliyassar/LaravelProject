@extends('welcome')

@section('title') My Orders - NovaStore @endsection

@section('content')
<div class="container">
    <h3 class="fw-bold text-dark mb-4"><i class="fa-solid fa-box-open text-primary me-2"></i>My Orders</h3>

    @forelse($orders as $order)
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center py-3 border-bottom">
                <div>
                    <span class="text-muted small text-uppercase fw-bold d-block">Order Placed</span>
                    <strong class="text-dark">{{ $order->created_at->format('d M Y H:i') }}</strong>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-bold d-block">Total Amount</span>
                    <strong class="text-success">${{ number_format($order->total, 2) }}</strong>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-bold d-block">Ship To</span>
                    <strong class="text-dark">{{ $order->name }}</strong>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-bold d-block">Status</span>
                    @if($order->status == 'New' || $order->status == 'Pending')
                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold">Pending Approval</span>
                    @elseif($order->status == 'Onshipping')
                        <span class="badge bg-info text-white px-3 py-2 fw-bold"><i class="fa-solid fa-truck fast me-1"></i> On Shipping</span>
                    @elseif($order->status == 'Completed')
                        <span class="badge bg-success text-white px-3 py-2 fw-bold"><i class="fa-solid fa-circle-check me-1"></i> Completed</span>
                    @else
                        <span class="badge bg-danger text-white px-3 py-2 fw-bold">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr style="font-size: 13px;" class="text-muted text-uppercase fw-bold">
                                <th>Product Details</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 text-center me-3" style="width: 50px;">
                                                <i class="fa-solid fa-box text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold" style="font-size: 15px;">{{ $item->product_title }}</h6>
                                                <small class="text-muted">ID: #{{ $item->product_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-secondary">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold text-dark">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 px-4 pb-3">
                <small class="text-muted d-block"><i class="fa-solid fa-location-dot me-1"></i> <strong>Delivery Address:</strong> {{ $order->address }}, {{ $order->city }} / {{ $order->country }}</small>
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0 rounded-3 text-center py-5 bg-white">
            <div class="card-body">
                <i class="fa-solid fa-bag-shopping fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold text-secondary">You haven't placed any orders yet.</h5>
                <p class="text-muted small">When you buy products, your order status and tracking details will appear here.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm fw-bold px-4 py-2 mt-2">Start Shopping</a>
            </div>
        </div>
    @endforelse
</div>
@endsection
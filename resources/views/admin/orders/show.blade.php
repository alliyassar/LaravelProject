<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Order Detail #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3 text-primary">Customer Information</h5>
                    <table class="table table-sm table-borderless">
                        <tr><td style="width: 120px;"><strong>Name:</strong></td><td>{{ $order->name }}</td></tr>
                        <tr><td><strong>Email:</strong></td><td>{{ $order->email }}</td></tr>
                        <tr><td><strong>Phone:</strong></td><td>{{ $order->phone ?? '-' }}</td></tr>
                        <tr><td><strong>Address:</strong></td><td>{{ $order->address }}</td></tr>
                        <tr><td><strong>City/Country:</strong></td><td>{{ $order->city }} / {{ $order->country }}</td></tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="border-bottom pb-2 mb-3 text-primary">Order Information</h5>
                    <table class="table table-sm table-borderless">
                        <tr><td style="width: 150px;"><strong>Payment Method:</strong></td><td>{{ $order->payment_method }}</td></tr>
                        <tr><td><strong>Shipping Method:</strong></td><td>{{ $order->shipping_method }}</td></tr>
                        <tr><td><strong>Order Date:</strong></td><td>{{ $order->created_at->format('m/d/Y H:i') }}</td></tr>
                    </table>

                    <div class="p-3 bg-light rounded border mt-3">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            <label class="form-label fw-bold">Update Order Status</label>
                            <div class="input-group">
                                <select name="status" class="form-select">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <h5 class="border-bottom pb-2 mb-3 mt-5 text-primary">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product ID</th>
                            <th>Product Title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $item->product_id ?? 'Deleted' }}</td>
                                <td class="fw-bold">{{ $item->product_title }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold text-dark">${{ number_format($item->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No order items found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-4">
                    <div class="bg-light p-3 rounded border">
                        <p class="d-flex justify-content-between mb-2"><span>Subtotal:</span> <span>${{ number_format($order->subtotal, 2) }}</span></p>
                        <p class="d-flex justify-content-between mb-2"><span>Shipping:</span> <span>${{ number_format($order->shipping_price, 2) }}</span></p>
                        <h5 class="d-flex justify-content-between border-top pt-2 mt-2 text-success"><span>Total:</span> <strong>${{ number_format($order->total, 2) }}</strong></h5>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
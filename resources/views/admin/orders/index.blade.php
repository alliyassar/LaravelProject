<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Orders List</h4>
            <span class="badge bg-light text-dark">Admin Panel</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter by Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Orders</option>
                        @foreach($statuses as $item)
                            <option value="{{ $item }}" {{ $status == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="fw-bold">{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone ?? '-' }}</td>
                                <td class="text-success fw-bold">${{ number_format($order->total, 2) }}</td>
                                <td>
                                    @if($order->status == 'New')
                                        <span class="badge bg-info text-dark">New</span>
                                    @elseif($order->status == 'Accepted')
                                        <span class="badge bg-primary">Accepted</span>
                                    @elseif($order->status == 'Cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($order->status == 'Onshipping')
                                        <span class="badge bg-warning text-dark">Onshipping</span>
                                    @elseif($order->status == 'Completed')
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('m/d/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Show</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

</body>
</html>
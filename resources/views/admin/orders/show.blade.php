@extends('admin.layout')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Order Detail #{{ $order->id }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">Order Detail</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h3 class="card-title"><i class="fas fa-user me-2"></i> Customer Information</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <tr>
                        <th style="width: 30%;">Name</th>
                        <td>{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td>{{ $order->city ?? 'Istanbul' }}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{ $order->country ?? 'Turkiye' }}</td>
                    </tr>
                    <tr>
                        <th>ZIP Code</th>
                        <td>{{ $order->zip_code ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card shadow-sm rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h3 class="card-title"><i class="fas fa-file-invoice me-2"></i> Order Information</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <tr>
                        <th style="width: 30%;">Order ID</th>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Current Status</th>
                        <td>
                            <span class="badge badge-{{ $order->status == 'New' ? 'info' : ($order->status == 'Accepted' ? 'primary' : ($order->status == 'Cancelled' ? 'danger' : ($order->status == 'Onshipping' ? 'warning' : 'success'))) }} p-2 rounded-0 text-uppercase">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td>Direct Bank Transfer</td>
                    </tr>
                    <tr>
                        <th>Shipping Method</th>
                        <td>Free Shipping</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td class="text-danger fw-bold">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
                
                <div class="p-3 bg-light border-top">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <label class="form-label fw-bold small text-uppercase text-secondary">Change Status</label>
                        <div class="input-group">
                            <select name="status" class="form-control rounded-0">
                                <option value="New" {{ $order->status == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Accepted" {{ $order->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Onshipping" {{ $order->status == 'Onshipping' ? 'selected' : '' }}>Onshipping</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <button type="submit" class="btn btn-primary rounded-0 px-4">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
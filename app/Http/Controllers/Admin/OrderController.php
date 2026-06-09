<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $orders = Order::with('user')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        $statuses = ['New', 'Accepted', 'Cancelled', 'Onshipping', 'Completed'];
        return view('admin.orders.index', compact('orders', 'statuses', 'status'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        $statuses = ['New', 'Accepted', 'Cancelled', 'Onshipping', 'Completed'];
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:New,Accepted,Cancelled,Onshipping,Completed',
        ]);
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);
        return back()->with('success', 'Order status updated successfully.');
    }
}
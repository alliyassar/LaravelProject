<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Admin panelinde tüm siparişleri listeler ve duruma göre filtreler.
     */
    public function index(Request $request)
    {
        $status = $request->status;
        
        $orders = Order::with('user')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $statuses = Order::STATUSES;

        return view('admin.orders.index', compact('orders', 'statuses', 'status'));
    }

    /**
     * Belirli bir siparişin faturasını ve içindeki ürün kalemlerini gösterir.
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        $statuses = Order::STATUSES;

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Siparişin durumunu günceller (Örn: New -> Accepted).
     */
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
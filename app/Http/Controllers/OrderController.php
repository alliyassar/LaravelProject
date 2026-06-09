<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // ÖDEME SAYFASI
    public function checkout()
    {
        $cartItems = Auth::check() 
            ? Cart::with('product')->where('user_id', Auth::id())->get() 
            : collect();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $shippingPrice = 0;
        $total = $subtotal + $shippingPrice;

        return view('home.checkout', compact('cartItems', 'subtotal', 'shippingPrice', 'total'));
    }

    // MÜŞTERİ SİPARİŞ TAKİP ALANI (PDF Madde 9)
    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Giriş yapmış kullanıcının siparişlerini ve içindeki ürünleri çekiyoruz
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('home.my_orders', compact('orders'));
    }

    // SİPARİŞ OLUŞTURMA (PLACE ORDER)
    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $shippingPrice = 0;
        $total = $subtotal + $shippingPrice;

        DB::transaction(function () use ($request, $cartItems, $subtotal, $total, $shippingPrice) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'subtotal' => $subtotal,
                'shipping_price' => $shippingPrice,
                'total' => $total,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'status' => 'New',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_title' => $item->product->title ?? 'Product',
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }
}
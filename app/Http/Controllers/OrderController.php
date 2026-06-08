<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Kullanıcıyı sepetindeki ürünlerle birlikte fatura/adres (Checkout) sayfasına gönderir.
     */
    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shippingPrice = 0; // Varsayılan ücretsiz kargo
        $total = $subtotal + $shippingPrice;

        return view('home.checkout', compact('cartItems', 'subtotal', 'shippingPrice', 'total'));
    }

    /**
     * Fatura bilgilerini alır, siparişi ve sipariş kalemlerini oluşturur, stoğu düşer.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'required|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:50',
            'shipping_method' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        try {
            // Veritabanı işlemlerini güvenli bir tünelde yapıyoruz kanka
            DB::transaction(function () use ($request, $cartItems) {
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                
                // Kargo yöntemine göre fiyat belirleme
                $shippingPrice = $request->shipping_method === 'Standard Shipping' ? 4 : 0;
                $total = $subtotal + $shippingPrice;

                // 1. Ana Sipariş Kaydını Oluştur
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

                // 2. Sepetteki ürünleri tek tek Sipariş Kalemlerine (Faturaya) aktar
                foreach ($cartItems as $item) {
                    $product = $item->product;
                    
                    if (!$product || $product->stock < $item->quantity) {
                        throw new \Exception(($product->name ?? 'Product') . ' does not have enough stock.');
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_title' => $product->name, // Bizim tablodaki name alanına eşitledim kral
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'total' => $item->price * $item->quantity,
                    ]);

                    // Ürün stoğundan düş kanka
                    $product->decrement('stock', $item->quantity);
                }

                // 3. Sipariş bittiği için kullanıcının sepetini boşalt
                Cart::where('user_id', Auth::id())->delete();
            });

            return redirect()->route('home')
                ->with('success', 'Your order has been placed successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
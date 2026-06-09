<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        // Giriş yapılmadıysa çökme, boş koleksiyon gönder kral
        $cartItems = auth()->check() 
            ? Cart::with('product')->where('user_id', auth()->id())->get() 
            : collect();

        return view('home.cart', compact('cartItems'));
    }

  public function add(Request $request, $id)
{
    // Rotalardan gelen $id parametresi ile ürünü buluyoruz
    $product = \App\Models\Product::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found!');
    }

    // Giriş yapmış kullanıcının id'sini alıyoruz
    $userId = auth()->id() ?? 1; // Eğer giriş zorunlu değilse test için varsayılan 1 yap kanka

    // Kullanıcının sepetinde bu ürün zaten var mı kontrol et
    $cartItem = \App\Models\Cart::where('user_id', $userId)
                                ->where('product_id', $product->id)
                                ->first();

    if ($cartItem) {
        // Varsa miktarını artır
        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();
    } else {
        // Yoksa sıfırdan veritabanına ekle (Hata veren yer burasıydı, düzelttik!)
        \App\Models\Cart::create([
            'user_id'    => $userId,
            'product_id' => $product->id, // Eksik olan ve SQL'i patlatan alan burasıydı reis
            'quantity'   => $request->input('quantity', 1),
            'price'      => $product->price,
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart successfully!');
}

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Kullanıcının sepetindeki ürünleri listeler.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        return view('home.cart', compact('cartItems'));
    }

    /**
     * Seçilen ürünü sepete ekler (Stok kontrolü yapar).
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->quantity ?? 1;

        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart->update([
                'quantity' => $newQuantity,
                'price' => $product->price,
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    /**
     * Sepetteki ürün adedini günceller.
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->findOrFail($cartId);

        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Ürünü sepetten tamamen siler.
     */
    public function remove($cartId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->findOrFail($cartId);
        $cart->delete();

        return back()->with('success', 'Product removed from cart.');
    }
}
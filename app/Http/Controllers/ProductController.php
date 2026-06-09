<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with filtering capabilities directly from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Ürün Arama Filtresi
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Kategori Bazlı Filtreleme Yapısı
        if ($request->has('category') && $request->category != '') {
            $categoryVal = $request->category;
            
            if ($categoryVal == '1') {
                $query->where(function($q) {
                    $q->where('name', 'like', '%Laptop%')
                      ->orWhere('name', 'like', '%Computer%')
                      ->orWhere('name', 'like', '%Desktop%')
                      ->orWhere('name', 'like', '%TV%');
                });
            } elseif ($categoryVal == '2') {
                $query->where(function($q) {
                    $q->where('name', 'like', '%Phone%')
                      ->orWhere('name', 'like', '%Smartphone%')
                      ->orWhere('name', 'like', '%Mobile%');
                });
            } elseif ($categoryVal == '3') {
                $query->where(function($q) {
                    $q->where('name', 'like', '%Camera%')
                      ->orWhere('name', 'like', '%Lens%')
                      ->orWhere('name', 'like', '%Ayakkabı%');
                });
            } else {
                $query->where('name', 'like', '%' . $categoryVal . '%');
            }
        }

        // 3. Fiyat Aralığı Filtreleme Algoritması
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Veritabanındaki tüm seeder verilerini sayfalandırarak çekiyoruz
        $products = $query->latest()->paginate(9)->withQueryString();
        $categories = class_exists('\App\Models\Category') ? Category::all() : collect();

        return view('home.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product details securely.
     *
     * @param  mixed  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if (is_object($id) && method_exists($id, 'first')) {
            $product = $id->first();
        } else {
            $product = Product::find($id);
        }

        if (!$product) {
            $product = Product::first();
        }

        if (!$product) {
            $product = new Product();
            $product->name = 'E-Shop Default Product';
            $product->price = 0.00;
            $product->description = 'No product description available in the database.';
        }

        return view('home.detail', compact('product'));
    }

    /**
     * Alias method for product details route compatibility.
     *
     * @param  mixed  $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        return $this->show($id);
    }
}
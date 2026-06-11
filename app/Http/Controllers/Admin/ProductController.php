<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Admin Panelinde Ürünleri Listeleme (DataTables Uyumlu)
    public function index()
    {
        $products = DB::table('products')->get();
        return view('admin.products.index', compact('products'));
    }

    // Yeni Ürün Ekleme Sayfası
    public function create()
    {
        return view('admin.products.create');
    }

    // Ürünü Veritabanına Kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'nullable|string',
        ]);

        DB::table('products')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => (int)$request->category,
            'image_url' => 'Dell Tower Plus Desktop.webp',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }
}
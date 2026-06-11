<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // Kategorileri Listeleme
    public function index()
    {
        // Veritabanından verileri çekiyoruz
        $categories = DB::table('categories')->get();
        
        // KRAL DİKKAT: Buradaki adresi 'admin.categories.index' yaparak 
        // sistemi doğrudan admin klasörünün içine bakmaya zorluyoruz!
        return view('admin.categories.index', compact('categories'));
    }

    // Yeni Kategori Ekleme Formu
    public function create()
    {
        // Burayı da admin klasörünün altındaki create dosyasına yönlendiriyoruz
        return view('admin.categories.create');
    }

    // Kategoriyi Veritabanına Kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Veritabanına fırlatıyoruz
        DB::table('categories')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }
}
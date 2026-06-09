<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tüm ürünlerin resimleri klasöründeki isimlerle %100 harfi harfine senkronize edildi
        $productsData = [
            [
                'name' => 'Dell Tower Plus Desktop',
                'price' => 10000.00,
                'category' => '1',
                'description' => 'High-performance workstation equipped with professional hardware graphics card unit.',
                'image' => 'Dell Tower Plus Desktop.webp'
            ],
            [
                'name' => 'MacBook Pro M3 Max',
                'price' => 2499.00,
                'category' => '1',
                'description' => 'Supercharged by M3 Max chip, delivering extreme performance for advanced software development workflows.',
                'image' => 'MacBook Pro M3 Max.webp'
            ],
            [
                'name' => 'Asus ROG Strix Laptop',
                'price' => 1899.99,
                'category' => '1',
                'description' => 'High refresh rate display with cutting edge cooling thermal system designed for competitive gaming.',
                'image' => 'Asus ROG Strix Laptop.webp'
            ],
            [
                'name' => 'iPhone 17 Pro Max',
                'price' => 1399.00,
                'category' => '2',
                'description' => 'Titanium chassis frame utilizing advanced spatial zoom camera sensors and next-generation neural engines.',
                'image' => 'iPhone 17 Pro Max.webp'
            ],
            [
                'name' => 'Samsung Galaxy S26 Ultra',
                'price' => 1199.00,
                'category' => '2',
                'description' => 'Dynamic AMOLED display integrated with embedded digital productivity stylus.',
                'image' => 'Samsung Galaxy S26 Ultra.webp'
            ],
            [
                'name' => 'Sony Alpha Mirrorless',
                'price' => 2199.00,
                'category' => '3',
                'description' => 'Full-frame image sensor architecture optimized for cinematic video outputs.',
                'image' => 'Sony Alpha Mirrorless.webp'
            ],
            [
                'name' => 'Canon EOS DSLR Pro',
                'price' => 1550.00,
                'category' => '3',
                'description' => 'Ergonomic physical body configuration holding dynamic range metering controls.',
                'image' => 'Canon EOS DSLR Pro.webp'
            ],
            [
                'name' => 'Noise-canceling headphones',
                'price' => 2499.00,
                'category' => '2',
                'description' => 'Advanced acoustic noise cancellation units delivering high-fidelity audio frequencies.',
                'image' => 'Noise-canceling headphones.webp' // Yeni kulaklık resmin cuk diye buraya oturdu
            ],
            [
                'name' => 'Nike shoe',
                'price' => 999.00,
                'category' => '3',
                'description' => 'Sports-oriented footwear engineered with shock absorption and ergonomic sole structures.',
                'image' => 'Nike shoe.webp' // Yeni ayakkabı resmin cuk diye buraya oturdu
            ]
        ];

        $hasCategoryId = Schema::hasColumn('products', 'category_id');
        $hasCategory = Schema::hasColumn('products', 'category');
        $hasImageUrl = Schema::hasColumn('products', 'image_url');
        $hasImage = Schema::hasColumn('products', 'image');
        $hasStock = Schema::hasColumn('products', 'stock');
        $hasStatus = Schema::hasColumn('products', 'status');

        foreach ($productsData as $data) {
            $product = new Product();
            $product->name = $data['name'];
            $product->price = $data['price'];
            $product->description = $data['description'];

            if ($hasCategoryId) {
                $product->category_id = (int)$data['category'];
            } elseif ($hasCategory) {
                $product->category = $data['category'];
            }

            if ($hasImageUrl) {
                $product->image_url = $data['image'];
            } elseif ($hasImage) {
                $product->image = $data['image'];
            }

            if ($hasStock) { $product->stock = 50; }
            if ($hasStatus) { $product->status = 'active'; }

            $product->save();
        }
    }
}
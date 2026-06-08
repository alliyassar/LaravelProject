<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Laravel'in veritabanına toplu veri yazmasına izin veren koruma filtresi
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ]; // <-- Dizi burada güvenle kapanıyor kanka

    // Fonksiyonlar dizinin DIŞINDA, sınıfın İÇİNDE olmalı:
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
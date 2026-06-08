<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Toplu veri eklemeye izin verdiğimiz kolonlar
    protected $fillable = [
        'name',
        'description'
    ];
}
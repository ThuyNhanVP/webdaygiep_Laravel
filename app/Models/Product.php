<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // bảng trong DB
    protected $fillable = [
        'name', 'price', 'category', 'colors', 'tag', 'image_main', 'image_hover'
    ];
    public $timestamps = false; // nếu bảng không có created_at, updated_at
    
}

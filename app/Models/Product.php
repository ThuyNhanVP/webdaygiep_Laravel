<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'category',
        'colors',
        'mau_sac',
        'so_luong_kho',
        'tag',
        'image_main',
        'image_hover',
    ];

    // Tu dong giai ma JSON khi doc
    protected $casts = [
        'mau_sac' => 'array',
    ];

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'product_id', 'id');
    }
}

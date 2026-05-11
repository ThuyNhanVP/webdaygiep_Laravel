<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // bảng trong DB
    protected $fillable = [
        'name',
        'price',
        'category',
        'colors',
        'tag',
        'image_main',
        'image_hover',
        'quantity',
        'quantity_min'
    ];
    public $timestamps = false; // nếu bảng không có created_at, updated_at

    // 1 sản phẩm có thể nằm trong nhiều chi tiết đơn hàng
    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'product_id', 'id');
    }

    // Kiểm tra xem sản phẩm có đủ số lượng không
    public function hasEnoughStock($quantity)
    {
        return $this->quantity >= $quantity;
    }

    // Trừ số lượng từ kho
    public function decreaseStock($quantity)
    {
        $this->quantity -= $quantity;
        return $this->save();
    }

    // Cộng số lượng vào kho (nếu order bị hủy)
    public function increaseStock($quantity)
    {
        $this->quantity += $quantity;
        return $this->save();
    }
}
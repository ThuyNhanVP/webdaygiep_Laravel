<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang'; // tên bảng trong DB
    public $timestamps = false; // nếu bảng không có created_at, updated_at

    protected $fillable = [
        'don_hang_id',
        'product_id',
        'so_luong',
        'ngay_tao'
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

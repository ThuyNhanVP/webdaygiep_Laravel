<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';
    public $timestamps = false;

    protected $fillable = [
        'don_hang_id',
        'product_id',
        'so_luong',
        'mau_chon',
        'gia_tai_thoi_diem',
        'ngay_tao',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ChiTietDonHang;

class DonHang extends Model
{
    // tên bảng nếu khác với chuẩn Laravel
    protected $table = 'don_hang';

    // tắt tự động thêm created_at và updated_at
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id', 'id');
    }

    // nếu muốn chỉ định cột nào được phép insert/update
    protected $fillable = [
        'id',
        'user_id',
        'ngay_tao'
        // thêm các cột khác của bảng don_hang
    ];
}

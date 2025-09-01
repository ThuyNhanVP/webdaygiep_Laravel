<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    // tên bảng nếu khác với chuẩn Laravel
    protected $table = 'don_hang';

    // tắt tự động thêm created_at và updated_at
    public $timestamps = false;

    // nếu muốn chỉ định cột nào được phép insert/update
    protected $fillable = [
        'id',
        'user_id',
        'ngay_tao'
        // thêm các cột khác của bảng don_hang
    ];
}

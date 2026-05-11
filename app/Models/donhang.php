<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';
    public $timestamps = false;
    const CREATED_AT = 'ngay_tao';

    protected $fillable = [
        'user_id',
        'dia_chi',
        'ngay_tao',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id', 'id');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Thời gian khuyến mãi còn lại
        $promo_left = 0;

        if (Auth::check()) {
            $promo_end = DB::table('users')
                ->where('id', Auth::id())
                ->value('promo_end');

            if ($promo_end) {
                $promo_left = Carbon::parse($promo_end)->timestamp - now()->timestamp;
                if ($promo_left < 0) {
                    $promo_left = 0;
                }
            }
        }

        // Lấy tất cả sản phẩm
        $products = Product::all();

        // Gửi ra view
        return view('home', compact('promo_left', 'products'));
    }
}

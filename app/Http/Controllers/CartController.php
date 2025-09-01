<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartController extends Controller
{
    // Xem giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
        $cart_open_time = Session::get('cart_open_time', time());
        $time_left = 30 - (time() - $cart_open_time);

        if ($time_left <= 0) {
            Session::forget('cart');
            Session::forget('cart_open_time');
            $msg = "Giỏ hàng đã hết thời gian (30 giây) và được xóa!";
            $products = [];
        } else {
            $products = [];
            $totalPrice = 0;
            foreach ($cart as $item) {
                $product = DB::table('products')->where('id', $item['product_id'])->first();
                if ($product) {
                    $product->so_luong = $item['so_luong'] ?? 1;
                    $products[] = $product;
                    $totalPrice += $product->price * $product->so_luong;
                }
            }
        }

        return view('cart.index', [
            'products' => $products ?? [],
            'totalPrice' => $totalPrice ?? 0,
            'time_left' => $time_left > 0 ? $time_left : 0,
            'msg' => $msg ?? null,
        ]);
    }
    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Lấy giỏ hàng hiện tại từ session
        $cart = Session::get('cart', []);

        // Nếu sản phẩm đã có thì tăng số lượng
        if (isset($cart[$product->id])) {
            $cart[$product->id]['so_luong'] += $request->so_luong ?? 1;
        } else {
            // Nếu chưa có thì thêm mới
            $cart[$product->id] = [
                'product_id' => $product->id,
                'ten_san_pham' => $product->ten_san_pham,
                'gia' => $product->gia,
                'so_luong' => $request->so_luong ?? 1,
                'anh' => $product->anh ?? null, // nếu có ảnh sản phẩm
            ];
        }

        // Lưu lại giỏ hàng
        Session::put('cart', $cart);
        Session::put('cart_open_time', time());

        // Nếu là request AJAX thì trả JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'cart_count' => count($cart),
            ]);
        }

        // Nếu không phải AJAX
        return redirect()->route('cart.index')->with('msg', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Xoá sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return back()->with('msg', 'Đã xoá sản phẩm khỏi giỏ hàng!');
    }


    // Xác nhận đơn hàng
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng rỗng!');
        }

        $user_id = Auth::id();

        // Lưu đơn hàng
        $don_hang_id = DB::table('don_hang')->insertGetId([
            'user_id' => $user_id,
            'ngay_tao' => now(),
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($cart as $item) {
            DB::table('chi_tiet_don_hang')->insert([
                'don_hang_id' => $don_hang_id,
                'product_id' => $item['product_id'],
                'so_luong' => $item['so_luong'] ?? 1,
                'ngay_tao' => now(),
            ]);
        }

        Session::forget('cart');
        Session::forget('cart_open_time');

        return redirect()->route('home')->with('success', 'Đơn hàng đã được lưu!');
    }
}

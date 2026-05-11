<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\DonHang;

class CartController extends Controller
{
    public function index()
    {
        $cartData   = Session::get('cart', []);
        $products   = [];
        $totalPrice = 0;

        if (!empty($cartData)) {
            // Fix N+1 query: Use whereIn instead of loop
            $productIds = array_unique(array_column($cartData, 'product_id'));
            $dbProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cartData as $item) {
                if (isset($dbProducts[$item['product_id']])) {
                    $product = $dbProducts[$item['product_id']];
                    $product->so_luong      = $item['so_luong'] ?? 1;
                    $product->mau_da_chon   = $item['mau_chon'] ?? null;
                    $product->cart_key      = $item['product_id'] . '_' . ($item['mau_chon'] ?? '');
                    $products[]             = $product;
                    $totalPrice            += $product->price * $product->so_luong;
                }
            }
        }

        $promo_end = Auth::user()->promo_end;
        $time_left = $promo_end ? (strtotime($promo_end) - time()) : 0;

        return view('cart.index', [
            'products'   => $products ?? [],
            'totalPrice' => $totalPrice ?? 0,
            'time_left'  => $time_left > 0 ? $time_left : 0,
            'msg'        => Session::get('msg'),
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'mau_chon'   => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->so_luong_kho <= 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'San pham da het hang!'], 400);
            }
            return back()->with('error', 'San pham da het hang!');
        }

        $cart    = Session::get('cart', []);
        $cartKey = $product->id . '_' . $request->mau_chon;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['so_luong'] += $request->so_luong ?? 1;
        } else {
            $cart[$cartKey] = [
                'product_id'   => $product->id,
                'ten_san_pham' => $product->name,
                'gia'          => $product->price,
                'so_luong'     => $request->so_luong ?? 1,
                'mau_chon'     => $request->mau_chon,
                'anh'          => $product->image_main ?? null,
            ];
        }

        Session::put('cart', $cart);
        Session::put('cart_open_time', time());

        if ($request->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => 'San pham da duoc them vao gio hang!',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->route('cart.index')->with('msg', 'Da them san pham vao gio hang!');
    }

    public function remove($key)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
        }
        return back()->with('msg', 'Da xoa san pham khoi gio hang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'so_dien_thoai' => 'required|regex:/^[0-9]{10,11}$/|max:11',
            'dia_chi'       => 'required|string|max:500',
        ], [
            'so_dien_thoai.required' => 'Số điện thoại không được bỏ trống.',
            'so_dien_thoai.regex'    => 'Số điện thoại phải từ 10 đến 11 chữ số.',
            'dia_chi.required'       => 'Địa chỉ không được bỏ trống.',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Gio hang rong!');
        }

        try {
            $user_id = Auth::id();
            
            // Use database transaction to ensure atomicity
            $don_hang_id = DB::transaction(function () use ($cart, $user_id, $request) {
                // Create order first
                $don_hang_id = DB::table('don_hang')->insertGetId([
                    'user_id'         => $user_id,
                    'so_dien_thoai'   => $request->so_dien_thoai,
                    'dia_chi'         => $request->dia_chi,
                    'ngay_tao'        => now(),
                ]);

                // Process each cart item with stock validation
                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                    
                    // Validate stock is still available
                    if ($product->so_luong_kho < ($item['so_luong'] ?? 1)) {
                        throw new \Exception('Sản phẩm ' . $product->name . ' không còn đủ hàng!');
                    }

                    // Create order detail
                    DB::table('chi_tiet_don_hang')->insert([
                        'don_hang_id'       => $don_hang_id,
                        'product_id'        => $item['product_id'],
                        'so_luong'          => $item['so_luong'] ?? 1,
                        'mau_chon'          => $item['mau_chon'] ?? null,
                        'gia_tai_thoi_diem' => $item['gia'],
                        'ngay_tao'          => now(),
                    ]);

                    // Decrement stock atomically
                    $product->decrement('so_luong_kho', $item['so_luong'] ?? 1);
                }

                return $don_hang_id;
            });

            Session::forget('cart');
            Session::forget('cart_open_time');

            return redirect()->route('user.orders')
                ->with('success', 'Đặt hàng thành công! Đơn hàng #' . $don_hang_id . ' đã được ghi nhận. Nhân viên sẽ sớm liên hệ lại với bạn!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    public function myOrders()
    {
        $orders = DonHang::with(['chiTietDonHang.product'])
            ->where('user_id', Auth::id())
            ->latest('ngay_tao')
            ->get();

        return view('user.my-orders', compact('orders'));
    }
}

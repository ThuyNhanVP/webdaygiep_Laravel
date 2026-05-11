<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'image_main'   => 'required|string',
            'so_luong_kho' => 'required|integer|min:0',
        ]);

        // Xu ly mau_sac thanh JSON array
        $mauSac = null;
        if (!empty($request->mau_sac)) {
            $arr    = array_map('trim', explode(',', $request->mau_sac));
            $mauSac = json_encode($arr, JSON_UNESCAPED_UNICODE);
        }

        Product::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'category'     => $request->category,
            'colors'       => $request->colors,
            'mau_sac'      => $mauSac,
            'so_luong_kho' => $request->so_luong_kho,
            'tag'          => $request->tag,
            'image_main'   => $request->image_main,
            'image_hover'  => $request->image_hover,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Đã thêm sản phẩm thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'so_luong_kho' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $mauSac = $product->mau_sac;
        if (!empty($request->mau_sac)) {
            $raw = is_array($request->mau_sac) ? $request->mau_sac : array_map('trim', explode(',', $request->mau_sac));
            $mauSac = json_encode($raw, JSON_UNESCAPED_UNICODE);
        }

        $product->update([
            'name'         => $request->name ?? $product->name,
            'price'        => $request->price ?? $product->price,
            'category'     => $request->category ?? $product->category,
            'colors'       => $request->colors ?? $product->colors,
            'mau_sac'      => $mauSac,
            'so_luong_kho' => $request->so_luong_kho,
            'tag'          => $request->tag,
            'image_main'   => $request->image_main ?? $product->image_main,
            'image_hover'  => $request->image_hover ?? $product->image_hover,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Đã cập nhật tồn kho!');
    }

    public function delete($id)
    {
        Product::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Đã xóa sản phẩm!');
    }

    public function orders()
    {
        $orders = \App\Models\DonHang::with(['chiTietDonHang.product', 'user'])
            ->latest('ngay_tao')
            ->get();
        return view('admin.orders', compact('orders'));
    }
}

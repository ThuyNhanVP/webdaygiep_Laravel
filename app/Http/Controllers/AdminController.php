<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\DonHang;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::paginate(15);
        return view('admin.products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0|max:999999999',
            'image_main'   => 'required|string',
            'so_luong_kho' => 'required|integer|min:0|max:999999',
            'category'     => 'nullable|string|max:255',
            'colors'       => 'nullable|string',
            'mau_sac'      => 'nullable|string',
            'tag'          => 'nullable|string|max:255',
            'image_hover'  => 'nullable|string',
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
            'so_luong_kho' => 'required|integer|min:0|max:999999',
            'name'         => 'nullable|string|max:255',
            'price'        => 'nullable|numeric|min:0|max:999999999',
            'category'     => 'nullable|string|max:255',
            'colors'       => 'nullable|string',
            'mau_sac'      => 'nullable|string',
            'tag'          => 'nullable|string|max:255',
            'image_main'   => 'nullable|string',
            'image_hover'  => 'nullable|string',
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
        $orders = DonHang::with(['chiTietDonHang.product', 'user'])
            ->latest('ngay_tao')
            ->paginate(15);
        return view('admin.orders', compact('orders'));
    }
}

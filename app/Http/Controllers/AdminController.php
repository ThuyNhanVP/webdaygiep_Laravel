<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Trả về view admin dashboard
        return view('admin.dashboard');
    }
    public function products() {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request) {
        Product::create($request->all());
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công');
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function deleteProduct($id) {
        Product::destroy($id);
        return redirect()->route('admin.products')->with('success', 'Xóa sản phẩm thành công');
    }

    public function orders() {
        $orders = DonHang::with(['user','chiTietDonHang.product'])->get();
        return view('admin.orders', compact('orders'));
    }
}

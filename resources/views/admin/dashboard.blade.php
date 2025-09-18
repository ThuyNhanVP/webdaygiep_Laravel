@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Tiêu đề -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Xin chào, Quản trị viên</h1>
    <p class="text-gray-600 mb-8">
        Đây là trang quản trị hệ thống giày dép. Bạn có thể quản lý sản phẩm và kiểm tra đơn hàng tại đây.
    </p>

    <!-- Các mục quản trị -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Quản lý sản phẩm -->
    <a href="{{ route('admin.products') }}"
       class="bg-white rounded-2xl shadow p-6 flex flex-col items-center justify-center hover:shadow-lg transition">
        <div class="w-16 h-16 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-full mb-4">
            <i class="fas fa-box text-2xl"></i>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Quản lý sản phẩm</h2>
        <p class="text-gray-500 text-sm mt-2">Thêm, sửa, xóa và cập nhật danh sách sản phẩm</p>
    </a>

    <!-- Quản lý đơn hàng -->
    <a href="{{ route('admin.orders') }}"
       class="bg-white rounded-2xl shadow p-6 flex flex-col items-center justify-center hover:shadow-lg transition">
        <div class="w-16 h-16 flex items-center justify-center bg-green-100 text-green-600 rounded-full mb-4">
            <i class="fas fa-shopping-cart text-2xl"></i>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Kiểm tra đơn hàng</h2>
        <p class="text-gray-500 text-sm mt-2">Theo dõi và xử lý đơn hàng của khách hàng</p>
    </a>

    <!-- Quay về Home -->
    <a href="{{ route('home') }}"
       class="bg-white rounded-2xl shadow p-6 flex flex-col items-center justify-center hover:shadow-lg transition">
        <div class="w-16 h-16 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full mb-4">
            <i class="fas fa-home text-2xl"></i>
        </div>
        <h2 class="text-xl font-semibold text-gray-800">Quay về Home</h2>
        <p class="text-gray-500 text-sm mt-2">Quay lại trang chủ của hệ thống</p>
    </a>
</div>

</div>
@endsection

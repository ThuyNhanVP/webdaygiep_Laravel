@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Tiêu đề -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Xin chào, Quản trị viên</h1>
    <p class="text-gray-600 mb-8">
        Đây là trang quản trị hệ thống giày dép. Bạn có thể quản lý sản phẩm và kiểm tra đơn hàng tại đây.
    </p>

    <!-- Thống kê tồn kho -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Tổng sản phẩm -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng sản phẩm</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $total_products }}</h3>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Hàng hết -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Hàng hết (0)</p>
                    <h3 class="text-2xl font-bold text-red-600">{{ $out_of_stock }}</h3>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-red-100 text-red-600 rounded-full">
                    <i class="fas fa-exclamation text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Hàng sắp hết -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Hàng sắp hết</p>
                    <h3 class="text-2xl font-bold text-orange-600">{{ count($low_stock_products) }}</h3>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-orange-100 text-orange-600 rounded-full">
                    <i class="fas fa-triangle-exclamation text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cảnh báo sản phẩm hàng sắp hết -->
    @if(count($low_stock_products) > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-yellow-400 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-yellow-800">⚠️ Cảnh báo tồn kho</h3>
                <p class="text-yellow-700 text-sm mt-2">Các sản phẩm sau đây có số lượng tồn kho thấp:</p>
                
                <div class="mt-4 space-y-2">
                    @foreach($low_stock_products as $product)
                    <div class="bg-white p-3 rounded flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">
                                Tồn kho: <span class="font-bold text-red-600">{{ $product->quantity }}</span> 
                                (Tối thiểu: {{ $product->quantity_min }})
                            </p>
                        </div>
                        <a href="{{ route('admin.products') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                            Nhập thêm →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

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

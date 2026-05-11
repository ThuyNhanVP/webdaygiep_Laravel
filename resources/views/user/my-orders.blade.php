@extends('layouts.app')
@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-box text-blue-600"></i>
                Đơn hàng của tôi
            </h1>
            <p class="text-gray-500 mt-2">Theo dõi tất cả các đơn hàng của bạn</p>
        </div>
        <a href="{{ route('home') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>Quay lại
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Orders List -->
    @forelse($orders as $don)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition-shadow">
        
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-package text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Đơn hàng #{{ $don->id }}</h3>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($don->ngay_tao)->format('d/m/Y  H:i') }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle mr-2"></i>Đã nhận đơn
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="grid grid-cols-2 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Người nhận</p>
                <p class="text-gray-900 font-semibold mt-1">{{ Auth::user()->ho_ten }}</p>
                <p class="text-sm text-gray-600 mt-2">
                    <i class="fas fa-phone text-blue-600 mr-2"></i>{{ $don->so_dien_thoai ?? 'Chưa cập nhật' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase">Địa chỉ giao hàng</p>
                <p class="text-gray-900 font-semibold mt-1">
                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>{{ $don->dia_chi }}
                </p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="px-6 py-4">
            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-list text-indigo-600"></i>Danh sách sản phẩm
            </h4>
            
            @foreach($don->chiTietDonHang as $ct)
            <div class="flex gap-4 pb-4 mb-4 border-b border-gray-200 last:border-0 last:pb-0 last:mb-0">
                <!-- Product Image -->
                <div class="flex-shrink-0">
                    <img src="{{ asset(optional($ct->product)->image_main ?? 'img/placeholder.png') }}"
                         alt="{{ optional($ct->product)->name }}"
                         class="w-20 h-20 object-cover rounded-lg bg-gray-100">
                </div>

                <!-- Product Details -->
                <div class="flex-1">
                    <h5 class="font-semibold text-gray-900">{{ optional($ct->product)->name ?? '(Sản phẩm đã xóa)' }}</h5>
                    
                    @if($ct->mau_chon)
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Màu:</span>
                            <span class="bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $ct->mau_chon }}</span>
                        </p>
                    @endif

                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                        <span>Số lượng: <strong class="text-gray-900">{{ $ct->so_luong }}</strong></span>
                        <span>Giá/SP: <strong class="text-blue-600">{{ number_format($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0, 0, ',', '.') }} VND</strong></span>
                    </div>
                </div>

                <!-- Item Total -->
                <div class="text-right flex-shrink-0">
                    <p class="text-gray-500 text-sm">Thành tiền</p>
                    <p class="text-lg font-bold text-blue-600">
                        {{ number_format(($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">VND</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Total -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Tổng số sản phẩm: <strong class="text-gray-900">{{ $don->chiTietDonHang->count() }}</strong></p>
            </div>
            <div class="text-right">
                <p class="text-gray-600 text-sm">Tổng cộng:</p>
                <p class="text-2xl font-bold text-blue-600">
                    {{ number_format($don->chiTietDonHang->sum(fn($ct) => ($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong), 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-500">VND</p>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 text-center py-16">
        <div class="mb-6">
            <i class="fas fa-inbox text-6xl text-gray-300"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-600 mb-3">Chưa có đơn hàng nào</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Bạn chưa tạo bất kỳ đơn hàng nào. Hãy khám phá sản phẩm và đặt hàng ngay!
        </p>
        <a href="{{ route('home') }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition font-semibold">
            <i class="fas fa-shopping-bag mr-2"></i>Bắt đầu mua sắm
        </a>
    </div>
    @endforelse
</div>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-white {
        animation: slideIn 0.3s ease-out;
    }
</style>
@endsection

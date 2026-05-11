@extends('layouts.app')
@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-boxes text-blue-600"></i>
                Quản lý đơn hàng
            </h1>
            <p class="text-gray-500 mt-2">Xem và quản lý tất cả các đơn hàng từ khách hàng</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2 h-fit">
            <i class="fas fa-arrow-left"></i>Quay lại
        </a>
    </div>

    <!-- Orders List -->
    @forelse($orders as $don)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition-shadow">
        
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">Đơn hàng #{{ $don->id }}</h3>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($don->ngay_tao)->format('d/m/Y  H:i') }}
                        </p>
                    </div>
                </div>
                <div class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle mr-2"></i>Đã tiếp nhận
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="grid grid-cols-3 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase mb-2">Khách hàng</p>
                <p class="text-gray-900 font-semibold">{{ $don->user->ho_ten ?? 'N/A' }}</p>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fas fa-user-circle mr-1 text-blue-500"></i>ID: {{ $don->user->id ?? 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase mb-2">Liên hệ</p>
                <p class="text-gray-900 font-semibold">
                    <i class="fas fa-phone text-green-500 mr-2"></i>{{ $don->so_dien_thoai ?? 'Chưa cập nhật' }}
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fas fa-envelope text-purple-500 mr-1"></i>{{ $don->user->email ?? 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase mb-2">Địa chỉ giao hàng</p>
                <p class="text-gray-900 font-semibold truncate">
                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>{{ $don->dia_chi ?: 'Chưa cập nhật' }}
                </p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Sản phẩm</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Màu</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">SL</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Đơn giá</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($don->chiTietDonHang as $ct)
                    <tr class="border-b border-gray-100 hover:bg-blue-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset(optional($ct->product)->image_main ?? 'img/placeholder.png') }}"
                                     alt="{{ optional($ct->product)->name ?? 'N/A' }}"
                                     class="w-12 h-12 object-cover rounded bg-gray-100">
                                <span class="font-medium text-gray-900">{{ $ct->product->name ?? '(Sản phẩm đã xóa)' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($ct->mau_chon)
                                <span class="bg-gray-100 px-3 py-1 rounded text-gray-700 text-sm font-medium">{{ $ct->mau_chon }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold text-sm">{{ $ct->so_luong }}</span>
                        </td>
                        <td class="px-6 py-4 text-right text-gray-900 font-medium">
                            {{ number_format($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0, 0, ',', '.') }} VND
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-blue-600">
                                {{ number_format(($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong, 0, ',', '.') }}
                            </span>
                            <p class="text-xs text-gray-500">VND</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Total -->
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-2 text-gray-600">
                <i class="fas fa-list"></i>
                <span>Tổng số sản phẩm: <strong class="text-gray-900">{{ $don->chiTietDonHang->count() }}</strong></span>
            </div>
            <div class="text-right">
                <p class="text-gray-600 text-sm">Tổng cộng:</p>
                <p class="text-2xl font-bold text-indigo-600">
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
        <h3 class="text-2xl font-bold text-gray-600 mb-3">Không có đơn hàng nào</h3>
        <p class="text-gray-500">Hiện tại chưa có đơn hàng nào trong hệ thống.</p>
    </div>
    @endforelse

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $orders->links() }}
    </div>
    @endif
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

    /* Table hover effect */
    tbody tr {
        transition: all 0.2s ease;
    }
</style>
@endsection

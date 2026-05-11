@extends('layouts.app')
@section('title', 'Giỏ hàng')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            <i class="fas fa-shopping-cart text-blue-600"></i>
            Giỏ hàng của bạn
        </h1>
        <p class="text-gray-500 mt-2">Quản lý sản phẩm và tiến hành thanh toán</p>
    </div>

    <!-- Alerts -->
    @if(session('msg'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items Section -->
        <div class="lg:col-span-2">
            @forelse($products as $p)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-4 hover:shadow-md transition-shadow">
                <div class="flex gap-4">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset($p->image_main) }}" alt="{{ $p->name }}" 
                             class="w-24 h-24 object-cover rounded-lg bg-gray-100">
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $p->name }}</h3>
                        
                        @if($p->mau_da_chon)
                            <p class="text-sm text-gray-600 mb-3">
                                <span class="font-medium">Màu:</span> 
                                <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $p->mau_da_chon }}</span>
                            </p>
                        @endif

                        <p class="text-xl font-bold text-blue-600 mb-3">
                            {{ number_format($p->price, 0, ',', '.') }} <span class="text-sm text-gray-500">VND</span>
                        </p>

                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Số lượng:</span> 
                            <span class="bg-blue-50 px-3 py-1 rounded text-blue-700 font-semibold">{{ $p->so_luong }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            <span class="font-medium">Thành tiền:</span> 
                            <span class="text-blue-600 font-semibold">{{ number_format($p->price * $p->so_luong, 0, ',', '.') }} VND</span>
                        </p>
                    </div>

                    <!-- Remove Button -->
                    <div class="flex-shrink-0 flex items-start">
                        @php $cartKey = $p->id . '_' . ($p->mau_da_chon ?? ''); @endphp
                        <form action="{{ route('cart.remove', $cartKey) }}" method="POST" 
                              onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded transition">
                                <i class="fas fa-trash-alt text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart text-5xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Giỏ hàng trống</h3>
                <p class="text-gray-500 mb-6">Hãy quay lại cửa hàng và thêm một số sản phẩm vào giỏ hàng của bạn</p>
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i>Tiếp tục mua sắm
                </a>
            </div>
            @endforelse
        </div>

        <!-- Order Summary Section -->
        @if(count($products) > 0)
        <div class="lg:col-span-1">
            <!-- Summary Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    <i class="fas fa-receipt mr-2 text-blue-600"></i>Tóm tắt đơn hàng
                </h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Tổng sản phẩm:</span>
                        <span class="font-semibold text-gray-900">{{ count($products) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span>Tổng số lượng:</span>
                        <span class="font-semibold text-gray-900">{{ collect($products)->sum('so_luong') }}</span>
                    </div>
                </div>

                <div class="border-t border-b border-gray-200 py-4 mb-6">
                    <div class="flex justify-between items-center text-xl">
                        <span class="font-bold text-gray-900">Tổng tiền:</span>
                        <span class="font-bold text-blue-600">{{ number_format($totalPrice, 0, ',', '.') }} VND</span>
                    </div>
                </div>

                <a href="{{ route('home') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-3 rounded-lg font-semibold transition mb-3">
                    <i class="fas fa-arrow-left mr-2"></i>Tiếp tục mua sắm
                </a>
            </div>

            <!-- Checkout Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">
                    <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Thông tin giao hàng
                </h2>

                <form action="{{ route('cart.checkout') }}" method="POST" 
                      onsubmit="return confirm('Bạn xác nhận đặt hàng? Nhân viên sẽ sớm gọi điện xác nhận đơn hàng của bạn.')">
                    @csrf

                    <div class="mb-4">
                        <label for="so_dien_thoai" class="block text-sm font-semibold text-gray-700 mb-3">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="so_dien_thoai" id="so_dien_thoai" required
                               placeholder="VD: 0912345678"
                               pattern="[0-9]{10,11}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('so_dien_thoai') }}">
                        @error('so_dien_thoai')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="dia_chi" class="block text-sm font-semibold text-gray-700 mb-3">
                            Địa chỉ nhận hàng <span class="text-red-500">*</span>
                        </label>
                        <textarea name="dia_chi" id="dia_chi" rows="3" required
                                  placeholder="VD: 123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        >{{ old('dia_chi') }}</textarea>
                        @error('dia_chi')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        Đặt hàng ngay
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Thông tin của bạn được bảo vệ
                    </p>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Custom animations */
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

    /* Smooth transitions */
    button, a {
        transition: all 0.3s ease;
    }

    /* Custom scrollbar for cart items */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection

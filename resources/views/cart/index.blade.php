@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="max-w-4xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">🛒 Giỏ hàng của bạn</h2>

    @if($msg)
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-medium">
            {{ $msg }}
        </div>
    @endif

    @forelse($products as $p)
        <div class="flex items-center justify-between border-b border-gray-200 py-4">
            <div class="flex items-center gap-4">
                {{-- Ảnh sản phẩm (nếu có cột image trong DB) --}}
                <img src="{{ $p->image_url ?? asset('images/no-image.png') }}" 
                     alt="{{ $p->name }}" 
                     class="w-16 h-16 object-cover rounded-lg border">
                <div>
                    <h4 class="text-lg font-semibold text-gray-700">{{ $p->name }}</h4>
                    <p class="text-gray-500">{{ number_format($p->price,0,',','.') }} VND</p>
                    <p class="text-sm text-gray-600">Số lượng: 
                        <span class="font-semibold">{{ $p->so_luong }}</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <div class="font-bold text-gray-800">
                    {{ number_format($p->price * $p->so_luong,0,',','.') }} VND
                </div>
                {{-- Nút xoá sản phẩm --}}
                <form method="POST" action="{{ route('cart.remove', $p->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="text-red-500 hover:text-red-700 text-sm font-medium">
                        ❌ Xoá
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500 italic">Giỏ hàng trống</p>
    @endforelse

    @if(count($products) > 0)
        <div class="mt-6 text-right">
            <p class="text-lg font-bold text-gray-800">Tổng tiền: 
                <span class="text-green-600">{{ number_format($totalPrice,0,',','.') }} VND</span>
            </p>

            <form method="POST" action="{{ route('cart.checkout') }}" class="mt-4">
                @csrf
                <button type="submit" 
                    class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl shadow-md transition">
                    Xác nhận đơn hàng
                </button>
            </form>

            <div class="mt-3 text-sm text-gray-600">
                ⏳ Thời gian còn lại: 
                <span id="countdown" class="font-semibold text-red-500">{{ $time_left }}</span> giây
            </div>
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" 
           class="inline-block px-5 py-2 rounded-lg border border-blue-500 text-blue-600 font-medium hover:bg-blue-50 transition">
            ⬅ Quay lại mua sắm
        </a>
    </div>
</div>

<script>
let timeLeft = {{ $time_left }};
const countdownEl = document.getElementById('countdown');
if(countdownEl){
    const timer = setInterval(() => {
        timeLeft--;
        if(timeLeft <= 0){
            clearInterval(timer);
            alert("Giỏ hàng đã hết thời gian và được xóa!");
            location.reload();
        } else {
            countdownEl.textContent = timeLeft;
        }
    }, 1000);
}
</script>
@endsection

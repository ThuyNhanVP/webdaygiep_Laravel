@extends('layouts.app')

@section('content')
<h2>Giỏ hàng</h2>

@if($msg)
    <p style="color:red;font-weight:bold;">{{ $msg }}</p>
@endif

<ul>
    @forelse($products as $p)
        <li>{{ $p->name }} - {{ number_format($p->price,0,',','.') }} VND x {{ $p->so_luong }}</li>
    @empty
        <li>Giỏ hàng trống</li>
    @endforelse
</ul>

@if(count($products) > 0)
    <div style="margin-top:20px;font-weight:bold;">
        Tổng tiền đơn hàng: {{ number_format($totalPrice,0,',','.') }} VND
    </div>

    <form method="POST" action="{{ route('cart.checkout') }}">
        @csrf
        <button type="submit">Xác nhận đơn hàng</button>
    </form>

    <div class="timer">
        Thời gian còn lại: <span id="countdown">{{ $time_left }}</span> giây
    </div>
@endif

<a href="{{ route('home') }}">Quay lại mua sắm</a>

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

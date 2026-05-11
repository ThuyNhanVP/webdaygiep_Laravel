@extends('layouts.app')
@section('title', 'Gio hang')

@section('content')
<div class="container" style="max-width:900px;margin:40px auto;padding:0 16px;">
    <h2 style="margin-bottom:24px;">Gio hang cua ban</h2>

    @if(session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse($products as $p)
    <div style="display:flex;align-items:center;gap:16px;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;background:#fff;">
        <img src="{{ asset($p->image_main) }}" alt="{{ $p->name }}" style="width:90px;height:90px;object-fit:cover;border-radius:6px;">
        <div style="flex:1;">
            <strong>{{ $p->name }}</strong><br>
            @if($p->mau_da_chon)
                <span style="color:#555;">Mau: <b>{{ $p->mau_da_chon }}</b></span><br>
            @endif
            <span>{{ number_format($p->price,0,',','.') }} VND</span><br>
            <span>So luong: {{ $p->so_luong }}</span>
        </div>
        <div>
            @php $cartKey = $p->id . '_' . ($p->mau_da_chon ?? ''); @endphp
            <form action="{{ route('cart.remove', $cartKey) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" style="background:#e74c3c;color:#fff;border:none;padding:6px 14px;border-radius:4px;cursor:pointer;">Xoa</button>
            </form>
        </div>
    </div>
    @empty
        <p>Gio hang trong.</p>
    @endforelse

    @if(count($products) > 0)
    <div style="text-align:right;font-size:1.1rem;margin-bottom:24px;">
        <strong>Tong tien: {{ number_format($totalPrice,0,',','.') }} VND</strong>
    </div>

    {{-- Form thanh toan voi dia chi --}}
<form action="{{ route('cart.checkout') }}" method="POST"
      onsubmit="return confirm('Bạn xác nhận đặt hàng? Nhân viên sẽ sớm gọi điện xác nhận đơn hàng của bạn.')"
      style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:24px;">
    @csrf
    <h4 style="margin-bottom:16px;">Thong tin nhan hang</h4>

    <div style="margin-bottom:16px;">
        <label for="dia_chi" style="display:block;margin-bottom:6px;font-weight:600;">Dia chi nhan hang <span style="color:red;">*</span></label>
        <textarea name="dia_chi" id="dia_chi" rows="3" required
            placeholder="VD: 123 Nguyen Hue, Quan 1, TP. Ho Chi Minh"
            style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;font-size:1rem;">{{ old('dia_chi') }}</textarea>
        @error('dia_chi')
            <span style="color:red;font-size:0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" style="background:#222;color:#fff;padding:12px 32px;border:none;border-radius:6px;font-size:1rem;cursor:pointer;width:100%;">
        Dat hang ngay
    </button>
</form>
    @endif
</div>
@endsection

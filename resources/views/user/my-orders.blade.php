@extends('layouts.app')
@section('title', 'Don hang cua toi')

@section('content')
<div style="max-width:960px;margin:40px auto;padding:0 16px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <h2 style="font-size:1.5rem;font-weight:700;">Đơn hàng của tôi</h2>
        <a href="{{ route('home') }}"
           style="background:#222;color:#fff;padding:8px 20px;border-radius:6px;text-decoration:none;font-size:0.9rem;">
            ← Về trang chủ
        </a>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:6px;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $don)
    <div style="border:1px solid #e5e7eb;border-radius:10px;margin-bottom:24px;overflow:hidden;background:#fff;">

        {{-- Header don --}}
        <div style="background:#f9fafb;padding:12px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e5e7eb;">
            <span><strong>Đơn hàng #{{ $don->id }}</strong></span>
            <span style="color:#6b7280;font-size:0.875rem;">
                {{ \Carbon\Carbon::parse($don->ngay_tao)->format('d/m/Y H:i') }}
            </span>
        </div>

        {{-- Dia chi --}}
        <div style="padding:10px 20px;border-bottom:1px solid #f3f4f6;font-size:0.9rem;color:#4b5563;">
            <strong>Địa chỉ nhận:</strong> {{ $don->dia_chi }}
        </div>

        {{-- Chi tiet san pham --}}
        <div style="padding:16px 20px;">
            @foreach($don->chiTietDonHang as $ct)
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f3f4f6;">
                <img src="{{ asset(optional($ct->product)->image_main ?? '') }}"
                     alt="{{ optional($ct->product)->name }}"
                     style="width:64px;height:64px;object-fit:cover;border-radius:6px;background:#f3f4f6;">
                <div style="flex:1;">
                    <div style="font-weight:600;">{{ optional($ct->product)->name ?? '(Sản phẩm đã xóa)' }}</div>
                    @if($ct->mau_chon)
                        <div style="font-size:0.875rem;color:#6b7280;">Màu: {{ $ct->mau_chon }}</div>
                    @endif
                    <div style="font-size:0.875rem;color:#6b7280;">
                        Số lượng: {{ $ct->so_luong }} &times; {{ number_format($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0, 0, ',', '.') }} VND
                    </div>
                </div>
                <div style="font-weight:700;white-space:nowrap;">
                    {{ number_format(($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong, 0, ',', '.') }} VND
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tong tien --}}
        <div style="padding:12px 20px;border-top:1px solid #e5e7eb;text-align:right;font-weight:700;font-size:1rem;">
            Tổng: {{ number_format($don->chiTietDonHang->sum(fn($ct) => ($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong), 0, ',', '.') }} VND
        </div>
    </div>
    @empty
        <div style="text-align:center;padding:80px 0;color:#9ca3af;">
            <div style="font-size:3rem;margin-bottom:16px;">📦</div>
            <p style="font-size:1.1rem;margin-bottom:16px;">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('home') }}" style="background:#222;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;">
                Mua hàng ngay
            </a>
        </div>
    @endforelse

</div>
@endsection

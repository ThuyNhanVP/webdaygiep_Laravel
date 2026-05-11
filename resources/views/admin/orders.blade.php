@extends('layouts.app')
@section('title', 'Quan ly don hang')

@section('content')
<div class="container" style="max-width:1100px;margin:40px auto;padding:0 16px;">
    <h2 style="margin-bottom:24px;">Tat ca don hang</h2>

    @forelse($orders as $don)
    <div style="border:1px solid #ddd;border-radius:8px;margin-bottom:24px;overflow:hidden;">
        <div style="background:#f0f0f0;padding:12px 20px;display:flex;justify-content:space-between;align-items:center;">
            <span>
                <strong>Don #{{ $don->id }}</strong> &mdash;
                Khach: <b>{{ $don->user->ho_ten ?? '—' }}</b>
                ({{ $don->user->SDT ?? '' }})
            </span>
            <span style="color:#777;font-size:0.9rem;">
                {{ \Carbon\Carbon::parse($don->ngay_tao)->format('d/m/Y H:i') }}
            </span>
        </div>

        <div style="padding:10px 20px;border-bottom:1px solid #eee;font-size:0.92rem;">
            <strong>Dia chi nhan:</strong> {{ $don->dia_chi ?: '(Chua co)' }}
        </div>

        <div style="padding:16px 20px;">
            <table style="width:100%;border-collapse:collapse;font-size:0.92rem;">
                <thead>
                    <tr style="background:#fafafa;">
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #eee;">San pham</th>
                        <th style="padding:8px;text-align:center;border-bottom:1px solid #eee;">Mau</th>
                        <th style="padding:8px;text-align:center;border-bottom:1px solid #eee;">SL</th>
                        <th style="padding:8px;text-align:right;border-bottom:1px solid #eee;">Don gia</th>
                        <th style="padding:8px;text-align:right;border-bottom:1px solid #eee;">Thanh tien</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($don->chiTietDonHang as $ct)
                    <tr>
                        <td style="padding:8px;">{{ $ct->product->name ?? '(Da xoa)' }}</td>
                        <td style="padding:8px;text-align:center;">{{ $ct->mau_chon ?? '—' }}</td>
                        <td style="padding:8px;text-align:center;">{{ $ct->so_luong }}</td>
                        <td style="padding:8px;text-align:right;">
                            {{ number_format($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0, 0, ',', '.') }} VND
                        </td>
                        <td style="padding:8px;text-align:right;">
                            {{ number_format(($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong, 0, ',', '.') }} VND
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="padding:10px 20px;border-top:1px solid #eee;text-align:right;font-weight:700;">
            Tong: {{ number_format($don->chiTietDonHang->sum(fn($ct) => ($ct->gia_tai_thoi_diem ?? optional($ct->product)->price ?? 0) * $ct->so_luong), 0, ',', '.') }} VND
        </div>
    </div>

    @empty
        <p>Chua co don hang nao.</p>
    @endforelse
</div>
@endsection

@extends('layouts.app')
@section('title', 'Quan ly san pham')

@section('content')
<div style="max-width:1100px;margin:40px auto;padding:0 16px;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <h2 style="font-size:1.5rem;font-weight:700;">Quản lý sản phẩm</h2>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.orders') }}" style="background:#2563eb;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;font-size:0.875rem;">Xem đơn hàng</a>
            <a href="{{ route('home') }}" style="background:#6b7280;color:#fff;padding:8px 16px;border-radius:6px;text-decoration:none;font-size:0.875rem;">← Trang chủ</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:6px;margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form them san pham --}}
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;margin-bottom:32px;">
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;">Thêm sản phẩm mới</h3>
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Tên sản phẩm *</label>
                    <input type="text" name="name" required placeholder="VD: Giày Samba OG"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Giá (VND) *</label>
                    <input type="number" name="price" required min="0" placeholder="VD: 2700000"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Danh mục</label>
                    <input type="text" name="category" placeholder="VD: Originals"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">
                        Số lượng trong kho *
                    </label>
                    <input type="number" name="so_luong_kho" required min="0" value="0" placeholder="VD: 10"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">
                        Danh sách màu <span style="font-weight:400;color:#6b7280;">(cách nhau bằng dấu phẩy)</span>
                    </label>
                    <input type="text" name="mau_sac" placeholder="VD: Trắng,Đen,Xanh navy"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Colors (hiển thị)</label>
                    <input type="text" name="colors" placeholder="VD: 2 colours"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Tag</label>
                    <input type="text" name="tag" placeholder="VD: Mới, Trending"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Ảnh chính *</label>
                    <input type="text" name="image_main" required placeholder="VD: img/1.png"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;font-size:0.875rem;font-weight:600;margin-bottom:4px;">Ảnh hover</label>
                    <input type="text" name="image_hover" placeholder="VD: img/1,1.avif"
                           style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;">
                </div>
            </div>
            <button type="submit" style="margin-top:16px;background:#222;color:#fff;padding:10px 28px;border:none;border-radius:6px;cursor:pointer;font-size:0.9rem;">
                + Thêm sản phẩm
            </button>
        </form>
    </div>

    {{-- Danh sach san pham --}}
    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
        <thead style="background:#f9fafb;">
            <tr>
                <th style="padding:12px 16px;text-align:left;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Ảnh</th>
                <th style="padding:12px 16px;text-align:left;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Tên</th>
                <th style="padding:12px 16px;text-align:left;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Giá</th>
                <th style="padding:12px 16px;text-align:center;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Tồn kho</th>
                <th style="padding:12px 16px;text-align:left;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Màu sắc</th>
                <th style="padding:12px 16px;text-align:left;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Tag</th>
                <th style="padding:12px 16px;text-align:center;font-size:0.875rem;border-bottom:1px solid #e5e7eb;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $p)
            <tr style="border-bottom:1px solid #f3f4f6;">
                <td style="padding:10px 16px;">
                    <img src="{{ asset($p->image_main) }}" alt="{{ $p->name }}"
                         style="width:56px;height:56px;object-fit:cover;border-radius:4px;background:#f3f4f6;">
                </td>
                <td style="padding:10px 16px;font-weight:500;">{{ $p->name }}</td>
                <td style="padding:10px 16px;">{{ number_format($p->price,0,',','.') }} VND</td>
                <td style="padding:10px 16px;text-align:center;">
                    @if($p->so_luong_kho <= 0)
                        <span style="background:#fee2e2;color:#dc2626;padding:2px 10px;border-radius:99px;font-size:0.8rem;font-weight:600;">Hết hàng</span>
                    @elseif($p->so_luong_kho <= 3)
                        <span style="background:#fef3c7;color:#d97706;padding:2px 10px;border-radius:99px;font-size:0.8rem;font-weight:600;">{{ $p->so_luong_kho }} (sắp hết)</span>
                    @else
                        <span style="background:#d1fae5;color:#059669;padding:2px 10px;border-radius:99px;font-size:0.8rem;font-weight:600;">{{ $p->so_luong_kho }}</span>
                    @endif
                </td>
                <td style="padding:10px 16px;font-size:0.875rem;color:#6b7280;">
                    @php $mauList = is_array($p->mau_sac) ? $p->mau_sac : (json_decode($p->mau_sac,true) ?? []); @endphp
                    {{ implode(', ', $mauList) }}
                </td>
                <td style="padding:10px 16px;">{{ $p->tag ?? '—' }}</td>
                <td style="padding:10px 16px;text-align:center;">
                    {{-- Nut cap nhat ton kho nhanh --}}
                    <form method="POST" action="{{ route('admin.products.update', $p->id) }}" style="display:inline-flex;align-items:center;gap:6px;margin-bottom:4px;">
                        @csrf
                        <input type="hidden" name="name" value="{{ $p->name }}">
                        <input type="hidden" name="price" value="{{ $p->price }}">
                        <input type="hidden" name="category" value="{{ $p->category }}">
                        <input type="hidden" name="colors" value="{{ $p->colors }}">
                        <input type="hidden" name="mau_sac" value="{{ implode(',', $mauList) }}">
                        <input type="hidden" name="tag" value="{{ $p->tag }}">
                        <input type="hidden" name="image_main" value="{{ $p->image_main }}">
                        <input type="hidden" name="image_hover" value="{{ $p->image_hover }}">
                        <input type="number" name="so_luong_kho" value="{{ $p->so_luong_kho }}" min="0"
                               style="width:60px;padding:4px 6px;border:1px solid #d1d5db;border-radius:4px;text-align:center;">
                        <button type="submit"
                                style="background:#2563eb;color:#fff;padding:4px 10px;border:none;border-radius:4px;cursor:pointer;font-size:0.8rem;white-space:nowrap;">
                            Cập nhật
                        </button>
                    </form>
                    <br>
                    <form method="POST" action="{{ route('admin.products.delete', $p->id) }}" style="display:inline;"
                          onsubmit="return confirm('Xóa sản phẩm này?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="background:#ef4444;color:#fff;padding:4px 12px;border:none;border-radius:4px;cursor:pointer;font-size:0.8rem;">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;color:#9ca3af;">Chưa có sản phẩm nào.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

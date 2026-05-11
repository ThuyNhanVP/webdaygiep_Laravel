<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'G4 Sneaker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('stl.css') }}">
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- Navbar: chi hien o trang chu --}}
    @if(request()->routeIs('home'))
    <div style="position:fixed;top:0;right:0;z-index:999;display:flex;align-items:center;gap:8px;padding:10px 16px;background:rgba(255,255,255,0.95);box-shadow:0 1px 4px rgba(0,0,0,0.1);width:100%;">
        <span style="flex:1;font-weight:700;font-size:1.1rem;">G4 Sneaker</span>
        @auth
            <span style="font-size:0.9rem;color:#555;">Xin chào, {{ Auth::user()->ho_ten }}</span>
            <a href="{{ route('cart.index') }}" style="background:#222;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;text-decoration:none;">GIỎ HÀNG</a>
            <a href="{{ route('user.orders') }}" style="background:#2563eb;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;text-decoration:none;">ĐƠN HÀNG</a>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" style="background:#7c3aed;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;text-decoration:none;">ADMIN</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:#e74c3c;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;border:none;cursor:pointer;">ĐĂNG XUẤT</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="background:#222;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;text-decoration:none;">ĐĂNG NHẬP</a>
            <a href="{{ route('register') }}" style="background:#555;color:#fff;padding:6px 14px;border-radius:4px;font-size:0.85rem;text-decoration:none;">ĐĂNG KÝ</a>
        @endauth
    </div>
    <div style="height:56px;"></div>
    @endif

    <div class="container mx-auto p-4">
        @yield('content')
    </div>

</body>
</html>

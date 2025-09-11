<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>G4 Plus</title>
    <link rel="stylesheet" href="{{ asset('css/stl.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="countdown-box">
        <p style="margin: 4px;">Khuyến mãi kết thúc sau:</p>
        <span id="countdown"></span>
    </div>
    <script>
        let promoLeft = {{ $promo_left }};
        function updateCountdown() {
            if (promoLeft <= 0) {
                document.getElementById("countdown").innerHTML = "Đã hết khuyến mãi!";
                return;
            }
            let hours = Math.floor(promoLeft / 3600);
            let minutes = Math.floor((promoLeft % 3600) / 60);
            let seconds = promoLeft % 60;
            document.getElementById("countdown").innerHTML = `${hours}h ${minutes}m ${seconds}s`;
            promoLeft--;
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>

    <section class="topmenu" style="padding-top: 2px">
        <ul>
            <li><a href="#">Trợ giúp</a></li>
            <li><a href="#">Trình theo dõi đơn hàng</a></li>
            <img src="{{ asset('img/Flag_of_Vietnam.svg.png') }}" alt="">
        </ul>
    </section>

    <div class="header_label">
        <div class="logo">
            <a href=""><img class="anh" src="{{ asset('img/log.png') }}" alt=""></a>
        </div>
    </div>

    <div class="menu">
        <ul>
            <li><a href="{{ route('home') }}">TRANG CHỦ</a></li>
            <li><a href="#">GIỚI THIỆU</a></li>
            <li><a href="#">LIÊN HỆ</a></li>
        </ul>
    </div>

    <div class="nothing"></div>

    <div class="boxlogin">
        @auth
            <span style="margin-right: 10px; margin-top: 6px; font-weight: bold; color: green;">
                Xin chào, {{ Auth::user()->ho_ten }}
            </span>
            <a href="{{ route('cart.index') }}"><button>GIỎ HÀNG</button></a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">ĐĂNG XUẤT</button>
            </form>
        @else
            <a href="{{ route('login') }}"><button>LOGIN</button></a>
            <a href="{{ route('cart.index') }}"><button>GIỎ HÀNG</button></a>
        @endauth
    </div>

    <div class="product">
        @foreach($products as $row)
            <div class="subproduct">
                <div class="imgproduct">
                    <img src="{{ asset($row->image_main) }}" @if(!empty($row->image_hover))
                    data-hover="{{ asset($row->image_hover) }}" @endif alt="">
                </div>
                <div class="detail">
                    <p>{{ number_format($row->price, 0, ',', '.') }} VND</p>
                    <p>{{ $row->name }}</p>
                    <p>{{ $row->category }}</p>
                    @if(!empty($row->colors))
                        <p>{{ $row->colors }}</p>
                    @endif
                    @if(!empty($row->tag))
                        <p style="font-weight: bold; display: inline; margin-right: 70px;">{{ $row->tag }}</p>
                    @endif
                    <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $row->id }}">
                        <input type="hidden" name="so_luong" value="1">
                        <button type="submit">Thêm vào giỏ hàng</button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

    <footer
        style="width:100%;background:#222;color:#fff;padding:10px 0 20px 0;position:relative;left:0;bottom:0; margin-top: 100px;">
        <div
            style="max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;">
            <div style="flex:1;min-width:200px;margin-bottom:20px;">
                <h3 style="margin-bottom:10px;">G4 Plus</h3>
                <p>© 2025 G4 Plus. All rights reserved.</p>
            </div>
            <div style="flex:1;min-width:200px;margin-bottom:20px;">
                <h4 style="margin-bottom:10px;">Liên hệ</h4>
                <p>Email: 2005thuynhan@gmail.com</p>
                <p>Hotline: 0965 027 644</p>
            </div>
            <div style="flex:1;min-width:200px;margin-bottom:20px;">
                <h4 style="margin-bottom:10px;">Theo dõi chúng tôi</h4>
                <a href="https://www.facebook.com/thuy.nhan.619727/"
                    style="color:#fff;margin-right:10px;text-decoration:none;">
                    <i class="fa-brands fa-facebook" style="margin-right: 4px;"></i>Facebook
                </a>
                <a href="#" style="color:#fff;margin-right:10px;text-decoration:none;">
                    <i class="fa-brands fa-instagram" style="margin-right: 4px;"></i>Instagram
                </a>
                <a href="#" style="color:#fff;text-decoration:none;">
                    <i class="fa-brands fa-youtube" style="margin-right: 4px;"></i>YouTube
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Hover đổi ảnh sản phẩm
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.imgproduct img').forEach(function (img) {
                const mainSrc = img.src;
                const hoverSrc = img.getAttribute('data-hover');
                if (hoverSrc) {
                    img.addEventListener('mouseenter', function () {
                        img.src = hoverSrc;
                    });
                    img.addEventListener('mouseleave', function () {
                        img.src = mainSrc;
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.add-to-cart-form');

            forms.forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Thông báo
                            const messageBox = document.createElement('div');
                            messageBox.textContent = data.message;
                            messageBox.style.position = 'fixed';
                            messageBox.style.top = '680px';
                            messageBox.style.right = '20px';
                            messageBox.style.backgroundColor = '#28a745';
                            messageBox.style.color = '#fff';
                            messageBox.style.padding = '10px 20px';
                            messageBox.style.borderRadius = '5px';
                            messageBox.style.zIndex = '9999';
                            document.body.appendChild(messageBox);

                            setTimeout(() => {
                                document.body.removeChild(messageBox);
                            }, 1000);
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                });
            });
        });
    </script>

</body>

</html>
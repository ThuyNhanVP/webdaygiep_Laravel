<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <style>
        body {background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);font-family: Arial;}
        form {width:300px;margin:120px auto;padding:20px;background:#fff;border-radius:5px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
        input {width:90%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;}
        .btn {display:flex;justify-content:space-between;}
        .btn input {width:48%;border:none;padding:10px;border-radius:5px;cursor:pointer;}
        .btn input[type=submit]{background:#28a745;color:#fff;}
        .btn input[type=reset]{background:#999;color:#000;}
    </style>
</head>
<body>
    <form id="form_dang_ky">
        <h2 style="text-align:center;margin-bottom:20px;">Đăng ký</h2>
        <label><strong>Họ tên</strong></label>
        <input type="text" name="ho_ten" required>

        <label><strong>Tên đăng nhập</strong></label>
        <input type="text" name="username" minlength="8" required>

        <label><strong>Mật khẩu</strong></label>
        <input type="password" name="password" required>

        <label><strong>Số điện thoại</strong></label>
        <input type="text" name="phone" pattern="[0-9]{10,11}" required>

        <p style="font-size:14px;">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>

        <div class="btn">
            <input type="reset" value="Nhập lại">
            <input type="submit" value="Đăng ký">
        </div>
        <div id="result" style="margin-top:10px;color:red;"></div>
    </form>

    <script>
        document.getElementById('form_dang_ky').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = e.target;
            const data = {
                ho_ten: form.ho_ten.value,
                username: form.username.value,
                password: form.password.value,
                phone: form.phone.value,
                _token: '{{ csrf_token() }}'
            };
            const res = await fetch('{{ route("register") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            document.getElementById('result').textContent = result.message;
            document.getElementById('result').style.color = result.success ? 'green' : 'red';
            if (result.success) {
                setTimeout(() => window.location.href = '{{ route("login") }}', 1000);
            }
        });
    </script>
</body>
</html>

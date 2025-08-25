<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);font-family: Arial;}
        form {width:300px;margin:150px auto;padding:20px;background:#fff;border-radius:5px;
              box-shadow:0 0 10px rgba(0,0,0,0.1);}
        form input {width:90%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;}
        .btn {display:flex;justify-content:space-between;}
        .btn button {width:48%;padding:10px;border:none;border-radius:5px;cursor:pointer;}
        .btn .submit {background:#28a745;color:white;}
        .btn .reset {background:rgb(144,144,144);color:black;}
    </style>
</head>
<body>
    <form id="form_dang_nhap" method="POST" action="{{ route('login.post') }}">
        @csrf
        <h2 style="text-align:center;margin-bottom:20px;">Đăng nhập</h2>

        <label><strong>Tên đăng nhập</strong></label>
        <input type="text" name="username" minlength="8" placeholder="Tên đăng nhập tối thiểu 8 ký tự" required>

        <label><strong>Nhập mật khẩu</strong></label>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <p style="font-size:14px;">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>

        <div class="btn">
            <button type="reset" class="reset">Nhập lại</button>
            <button type="submit" class="submit">Đăng nhập</button>
        </div>

        <div id="result" style="margin-top:10px;color:red;"></div>
    </form>

    <script>
    document.getElementById('form_dang_nhap').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            username: form.username.value,
            password: form.password.value,
            _token: form.querySelector('input[name="_token"]').value
        };

        const res = await fetch(form.action, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();
        document.getElementById('result').textContent = result.message;
        if (result.success) {
            document.getElementById('result').style.color = 'green';
            setTimeout(() => window.location.href = "{{ route('home') }}", 1000);
        } else {
            document.getElementById('result').style.color = 'red';
        }
    });
    </script>
</body>
</html>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Hiển thị form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý login
    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|min:8',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // chống session fixation
        return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!']);
    }

    return response()->json(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng!']);
}


    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $request->validate([
        'ho_ten' => 'required|string|max:255',
        'username' => 'required|string|min:8|unique:users,username',
        'password' => 'required|string|min:6',
        'phone' => ['required', 'regex:/^0(3|5|7|8|9)[0-9]{8}$/'],
    ]);

    $user = User::create([
        'ho_ten' => $request->ho_ten,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'SDT' => $request->phone,
        'promo_start' => now(),
        'promo_end' => now()->addHours(2),
    ]);

    Auth::login($user); // auto login sau khi đăng ký

    return response()->json([
        'success' => true,
        'message' => 'Đăng ký thành công và đã đăng nhập!'
    ]);
}


}



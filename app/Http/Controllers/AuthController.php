<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // GET /login
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Admin -> admin dashboard, user -> home
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng!'])->withInput();
    }

    // GET /register
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /register
    public function register(Request $request)
    {
        $request->validate([
            'ho_ten'   => 'required|string|max:255',
            'username' => 'required|string|min:8|unique:users,username',
            'password' => 'required|string|min:6',
            'phone'    => ['required', 'regex:/^0(3|5|7|8|9)[0-9]{8}$/'],
        ]);

        $user = User::create([
            'ho_ten'      => $request->ho_ten,
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'SDT'         => $request->phone,
            'promo_start' => now(),
            'promo_end'   => now()->addHours(2),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    // POST /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

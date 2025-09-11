<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Trả về view admin dashboard
        return view('admin.dashboard');
    }
}

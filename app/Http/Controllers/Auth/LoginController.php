<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login'); // صفحة تسجيل الدخول
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');

        }

        return back()->withErrors(['email'=>'البريد الإلكتروني أو كلمة السر غير صحيحة']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

    
}


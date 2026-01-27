<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_user');
    }

    public function login(Request $request)
    {
        $request->validate([
            'no_rumah' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'no_rumah' => $request->no_rumah,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'no_rumah' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

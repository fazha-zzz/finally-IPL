<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'no_rumah';
    }

    /**
     * Override redirect setelah login
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.pembayaran.index');
        }

        if ($user->role === 'user') {
            return redirect()->route('user.dashboard');
        }

        // Kalau role aneh → logout & balikin ke login dengan error
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'login' => 'Role tidak valid, hubungi admin.',
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

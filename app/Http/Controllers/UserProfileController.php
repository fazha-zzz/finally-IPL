<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $iklanCount = $user->iklan()->count();
        $kritikCount = $user->kritikSaran()->count();

        return view('users.profile.index', compact('user', 'iklanCount', 'kritikCount'));
    }
}

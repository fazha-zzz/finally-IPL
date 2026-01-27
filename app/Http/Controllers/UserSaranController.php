<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSaranController extends Controller
{
    public function index()
    {
        $saran = KritikSaran::where('id_user', Auth::id())->latest()->get();

        return view('users.saran.index', compact('saran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        KritikSaran::create([
            'id_user' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return redirect()->route('user.saran.index')->with('success', 'Kritik & saran berhasil dikirim!');
    }
}

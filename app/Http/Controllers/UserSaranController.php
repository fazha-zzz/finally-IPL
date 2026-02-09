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
        'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $kritik = KritikSaran::create([
        'id_user' => Auth::id(),
        'isi' => $request->isi,
        'balasan' => null,
    ]);

    if ($request->hasFile('gambar')) {
        foreach ($request->file('gambar') as $file) {
            $path = $file->store('kritik_saran', 'public');

            $kritik->gambars()->create([
                'path' => $path,
            ]);
        }
    }

        return redirect()->route('user.saran.index')->with('success', 'Kritik & saran berhasil dikirim!');
    }
}

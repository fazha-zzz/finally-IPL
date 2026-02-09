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
        'attachments.*' => [
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:2048'
        ]
    ]);

    $kritik = KritikSaran::create([
        'id_user' => Auth::id(),
        'isi'     => $request->isi,
        'balasan' => null,
    ]);

    // 📎 SIMPAN ATTACHMENT USER
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {

            // 🔐 rename biar aman
            $filename = time().'_'.uniqid().'.'.$file->extension();
            $path = $file->storeAs('kritik_saran_user', $filename, 'public');

            $kritik->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'type'      => 'user',
            ]);
        }
    }

    return redirect()
        ->route('user.saran.index')
        ->with('success', 'Kritik & saran berhasil dikirim!');
}
}

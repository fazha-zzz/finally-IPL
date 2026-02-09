<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use App\Models\KritikSaranGambar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KritikSaranController extends Controller
{
    public function index()
    {
        $kritiks = KritikSaran::with('user')
            ->latest()
            ->paginate(5);

        return view('admin.saran.index', compact('kritiks'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.saran.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'nullable|exists:users,id',
            'isi' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            KritikSaran::create($request->all());
        });

        return redirect()->route('admin.saran.index')->with('success', 'Kritik & saran berhasil dikirim.');
    }

    public function show($id)
    {
        $kritik = KritikSaran::with('user')->findOrFail($id);

        return view('admin.saran.show', compact('kritik'));
    }

    public function destroy($id)
    {
        $kritik = KritikSaran::findOrFail($id);

        // Otorisasi: pemilik atau admin
        if (auth()->user()->role !== 'admin' && $kritik->id_user !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($kritik) {
            $kritik->delete();
        });

        return redirect()->route('admin.saran.index')->with('success', 'Kritik & saran berhasil dihapus.');
    }

    public function balas(Request $request, $id)
{
    $kritik = KritikSaran::findOrFail($id);

    // 🔒 Kunci jika sudah dibalas
    if ($kritik->balasan !== null) {
        return back()->with('error', 'Balasan sudah dikirim');
    }

    // ✅ VALIDASI
    $request->validate([
        'balasan' => 'required|string',
        'attachments.*' => [
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:2048'
        ]
    ]);

    // 💾 SIMPAN BALASAN
    $kritik->update([
        'balasan' => $request->balasan
    ]);

    // 📎 SIMPAN LAMPIRAN ADMIN
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {

            $filename = time().'_'.uniqid().'.'.$file->extension();
            $path = $file->storeAs('kritik_saran_admin', $filename, 'public');

            $kritik->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'type' => 'admin',
            ]);
        }
    }

    return back()->with('success', 'Balasan berhasil dikirim');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IklanController extends Controller
{
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            $iklans = Iklan::with('user')->latest()->paginate(5);
        } else {
            $iklans = Iklan::with('user')
                ->where('id_user', auth()->id())
                ->latest()->paginate(5);
        }
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.iklan.index', compact('iklans', 'users'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.iklan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->except('gambar');
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time().'_'.$file->getClientOriginalName();

                $file = $file->storeAs('iklan', $filename, 'public');
                $data['gambar'] = $file;
            }
            Iklan::create($data);
        });

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $iklan = Iklan::findOrFail($id);
        $user = auth()->user();
        $admin = auth()->guard('admin')->user();
        if (! $admin && $iklan->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $users = User::where('role', '!=', 'admin')->get();

        return view('admin.iklan.edit', compact('iklan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);
        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (! $admin && $iklan->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $iklan) {
            $data = $request->except('gambar');

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama bila ada
                if ($iklan->gambar) {
                    Storage::disk('public')->delete($iklan->gambar);
                }

                // Simpan gambar baru
                $path = $request->file('gambar')->store('iklan', 'public');
                $data['gambar'] = $path;
            }

            $iklan->update($data);
        });

        return redirect()->route('admin.iklan.index')
            ->with('success', 'Iklan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        $user = auth()->user();
        $admin = auth()->guard('admin')->user();

        if (! $admin && $iklan->id_user !== $user->id) {
            abort(403, 'Unauthorized');
        }

        DB::transaction(function () use ($iklan) {
            if ($iklan->gambar) {
                Storage::disk('public')->delete($iklan->gambar);
            }
            $iklan->delete();
        });

        return redirect()->route('admin.iklan.index')
            ->with('success', 'Iklan berhasil dihapus.');
    }
}

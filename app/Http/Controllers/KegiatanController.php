<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->paginate(5);

        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->only([
                'nama_kegiatan',
                'deskripsi',
                'lokasi',
                'tanggal',
            ]);

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')
                    ->store('kegiatan', 'public');

                $data['gambar'] = $path;
            }

            Kegiatan::create($data);
        });

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);

        DB::transaction(function () use ($request, $kegiatan) {
            $data = $request->only([
                'nama_kegiatan',
                'deskripsi',
                'lokasi',
                'tanggal',
            ]);

            if ($request->hasFile('gambar')) {
                if ($kegiatan->gambar) {
                    Storage::disk('public')->delete($kegiatan->gambar);
                }

                $path = $request->file('gambar')
                    ->store('kegiatan', 'public');

                $data['gambar'] = $path;
            }

            $kegiatan->update($data);
        });

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        DB::transaction(function () use ($kegiatan) {
            if ($kegiatan->gambar) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }

            $kegiatan->delete();
        });

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus');
    }
}

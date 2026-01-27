<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class UserPengumumanController extends Controller
{
    public function index()
    {
        // Ambil data pengumuman terbaru, misalnya 5 pengumuman terakhir
        $pengumuman = Pengumuman::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengumuman',
            'data' => $pengumuman,
        ]);
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail pengumuman',
            'data' => $pengumuman,
        ]);
    }
}

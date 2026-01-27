<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;

class UserKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kegiatan',
            'data' => $kegiatan,
        ]);
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail kegiatan',
            'data' => $kegiatan,
        ]);
    }
}

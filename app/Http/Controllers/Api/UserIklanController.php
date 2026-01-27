<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Iklan;

class UserIklanController extends Controller
{
    /**
     * Tampilkan semua iklan (JSON)
     */
    public function index()
    {
        try {
            // Ambil semua iklan dengan relasi user (admin yang upload)
            $iklans = Iklan::with('user')->latest()->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar iklan berhasil diambil',
                'data' => $iklans,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data iklan: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detail iklan (JSON)
     */
    public function show($id)
    {
        try {
            $iklan = Iklan::with('user')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail iklan ditemukan',
                'data' => $iklan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Iklan tidak ditemukan',
            ], 404);
        }
    }
}

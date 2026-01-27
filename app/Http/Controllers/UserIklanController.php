<?php

namespace App\Http\Controllers;

use App\Models\Iklan;

class UserIklanController extends Controller
{
    /**
     * Tampilkan semua iklan untuk user
     */
    public function index()
    {
        try {
            // Ambil semua iklan dengan relasi user (admin yang upload)
            $iklans = Iklan::with('user')->latest()->get();

            return view('user.iklan.index', compact('iklans'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data iklan: '.$e->getMessage());
        }
    }

    /**
     * Detail iklan
     */
    public function show($id)
    {
        try {
            $iklan = Iklan::with('user')->findOrFail($id);

            return view('user.iklan.show', compact('iklan'));
        } catch (\Exception $e) {
            return back()->with('error', 'Iklan tidak ditemukan.');
        }
    }
}

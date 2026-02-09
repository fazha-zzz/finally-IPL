<?php

namespace App\Http\Controllers;

use App\Models\BiayaSetting;
use Illuminate\Http\Request;

class BiayaSettingController extends Controller
{
    public function index()
    {
        $setting = BiayaSetting::first();

        return view('admin.biaya_setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keamanan' => 'required|integer|min:0',
            'kebersihan' => 'required|integer|min:0',
            'denda' => 'required|integer|min:0',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        BiayaSetting::updateOrCreate(
            ['id' => 1], // selalu update id=1
            [
                'keamanan' => $request->keamanan,
                'kebersihan' => $request->kebersihan,
                'denda' => $request->denda,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            ]
        );

        return redirect()->back()->with('success', 'Pengaturan biaya berhasil disimpan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class UserPengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest()->paginate(5);

        return view('users.pengumuman.index', compact('pengumuman'));
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        return view('users.pengumuman.show', compact('pengumuman'));
    }
}

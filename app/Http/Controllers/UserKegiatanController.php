<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;

class UserKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::latest()->paginate(5);

        return view('users.kegiatan.index', compact('kegiatan'));
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('users.kegiatan.show', compact('kegiatan'));
    }
}

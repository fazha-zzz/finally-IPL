<?php

namespace App\Http\Controllers;

use App\Models\Dibayar;

class DibayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dibayars = Dibayar::with(['user', 'rekening'])->get();

        return view('dibayars.index', compact('dibayars'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dibayar = Dibayar::with(['user', 'rekening'])->findOrFail($id);

        return view('dibayars.show', compact('dibayar'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::orderBy('bank_name', 'asc')->paginate(10);

        return view('admin.rekenings.index', compact('rekenings'));
    }

    public function create()
    {
        return view('admin.rekenings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            Rekening::create($validated);
        });

        return redirect()->route('admin.rekenings.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rekening = Rekening::findOrFail($id);

        return view('admin.rekenings.show', compact('rekening'));
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);

        return view('admin.rekenings.edit', compact('rekening'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($id, $validated) {
            $rekening = Rekening::findOrFail($id);
            $rekening->update($validated);
        });

        return redirect()->route('admin.rekenings.index')->with('success', 'Rekening berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $rekening = Rekening::findOrFail($id);
            $rekening->delete();
        });

        return redirect()->route('admin.rekenings.index')->with('success', 'Rekening berhasil dihapus.');
    }
}

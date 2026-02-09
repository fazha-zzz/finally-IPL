<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSaranController extends Controller
{
    public function index()
    {
        $data = KritikSaran::with('attachments')
            ->where('id_user', Auth::id())
            ->latest()
            ->get();

         return response()->json([
        'auth_id' => Auth::id(),
        'data' => KritikSaran::where('id_user', Auth::id())
            ->with('attachments')
            ->latest()
            ->get()
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
            'attachments.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120'
        ]);

        $kritik = KritikSaran::create([
            'id_user' => Auth::id(),
            'isi' => $request->isi,
            'balasan' => null,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time().'_'.uniqid().'.'.$file->extension();
                $path = $file->storeAs('kritik_saran_user', $filename, 'public');

                $kritik->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'type' => 'user'
                ]);
            }
        }

        return response()->json([
            'message' => 'Kritik & saran berhasil dikirim'
        ]);
    }
}

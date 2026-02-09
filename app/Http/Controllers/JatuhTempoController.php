<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use App\Exports\JatuhTempoExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class JatuhTempoController extends Controller
{
    public function jatuhTempo(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');
    $status = $request->get('status');

    $query = Pembayaran::with('user')
        ->where('status', '!=', 'berhasil dibayar')
        ->whereDate('tanggal_jatuh_tempo', '<', Carbon::now());

    if ($search) {
        $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('no_rumah', 'like', "%{$search}%");
        });
    }

    if ($status) {
        $query->where('status', $status);
    }

    $data = $query->orderBy('tanggal_jatuh_tempo', 'asc')
        ->paginate($perPage)
        ->appends($request->all());

    return view('admin.Tempo.jatuh-tempo', compact('data'));
}

public function exportJatuhTempo()
{
    return Excel::download(new JatuhTempoExport, 'data_jatuh_tempo.xlsx');
}

public function exportJatuhTempoPdf()
{
    $data = Pembayaran::with('user')
        ->where('status', '!=', 'berhasil dibayar')
        ->whereDate('tanggal_jatuh_tempo', '<', Carbon::now())
        ->latest()
        ->get();

    $pdf = Pdf::loadView('admin.Tempo.jatuh_tempo_pdf', compact('data'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('data_jatuh_tempo.pdf');
}
}

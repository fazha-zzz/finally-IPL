<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class JatuhTempoExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
    {
        return Pembayaran::with('user')
            ->where('status', '!=', 'berhasil dibayar')
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::now())
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->user->name ?? '-',
                    'No Rumah' => $item->user->no_rumah ?? '-',
                    'Tanggal Jatuh Tempo' => Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y'),
                    'Total' => $item->total,
                    'Denda' => $item->denda,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'No Rumah',
            'Tanggal Jatuh Tempo',
            'Total',
            'Denda'
        ];
    }
}

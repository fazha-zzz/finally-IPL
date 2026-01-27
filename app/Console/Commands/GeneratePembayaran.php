<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Console\Command;

class GeneratePembayaran extends Command
{
    protected $signature = 'pembayaran:generate';

    protected $description = 'Generate pembayaran otomatis setiap awal bulan untuk semua user';

    public function handle()
    {
        $today = now()->startOfMonth()->toDateString();
        $users = User::all();

        foreach ($users as $user) {
            // cek apakah user sudah punya tagihan bulan ini
            $exists = Pembayaran::where('id_user', $user->id)
                ->whereDate('tanggal', $today)
                ->exists();

            if (! $exists) {
                Pembayaran::create([
                    'id_user' => $user->id,
                    'keamanan' => 101120,
                    'kebersihan' => 40000,
                    'tanggal' => $today,
                    'total' => 101120 + 40000,
                    'status' => 'belum terbayar',
                ]);
            }
        }

        $this->info('Tagihan bulan ini sudah diverifikasi untuk semua user (user baru otomatis dibuatkan).');
    }
}

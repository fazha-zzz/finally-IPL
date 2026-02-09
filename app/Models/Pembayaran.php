<?php

// app/Models/Pembayaran.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'id_user',
        'keamanan',
        'kebersihan',
        'tanggal_jatuh_tempo',
        'tanggal',
        'status',
        'order_id',
        'payment_type',
        'transaction_status',
        'dibayar_id',
        'total',
        'group_order_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dibayar()
    {
        return $this->belongsTo(Dibayar::class, 'dibayar_id', 'id');
    }

   public function getDendaAttribute()
{
    $setting = \App\Models\BiayaSetting::first();

    if (!$setting) return 0;

    if (
        $this->status !== 'berhasil dibayar' &&
        now()->greaterThan($this->tanggal_jatuh_tempo)
    ) {
        return $setting->denda;
    }

    return 0;
}

    public function getTotalDenganDendaAttribute()
    {
        return $this->total + $this->denda;
    }
}

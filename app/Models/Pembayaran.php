<?php

// app/Models/Pembayaran.php

namespace App\Models;

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
        'tanggal_tagih',
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
}

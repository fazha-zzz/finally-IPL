<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dibayar extends Model
{
    protected $table = 'dibayars';

    protected $fillable = [
        'id_user',
        'rekening_id',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'dibayar_id');
    }
}

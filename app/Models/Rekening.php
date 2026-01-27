<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekenings';

    protected $fillable = [
        'bank_name',
        'number',
    ];

    public function dibayars()
    {
        return $this->hasMany(Dibayar::class, 'rekening_id');
    }
}

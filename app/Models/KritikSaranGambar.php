<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KritikSaranGambar extends Model
{
    protected $table = 'kritik_saran_gambar';

    protected $fillable = ['kritik_saran_id', 'path'];

    public function kritikSaran()
    {
        return $this->belongsTo(KritikSaran::class);
    }
}

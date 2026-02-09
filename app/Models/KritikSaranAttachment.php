<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KritikSaranAttachment extends Model
{
    protected $table = 'kritik_saran_attachment';

    protected $fillable = [
        'kritik_saran_id',
        'type',
        'file_name',
        'file_path'

    ];

    public function kritikSaran()
    {
        return $this->belongsTo(KritikSaran::class);
    }


}

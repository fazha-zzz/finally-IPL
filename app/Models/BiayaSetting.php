<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaSetting extends Model
{
    use HasFactory;

    protected $table = 'biaya_settings';

    protected $fillable = ['keamanan', 'kebersihan', 'tanggal_tagih', 'tanggal_jatuh_tempo'];
}

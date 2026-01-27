<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'no_rumah',
        'no_tlp',
        'alamat',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function iklan()
    {
        return $this->hasMany(Iklan::class, 'id_user');
    }

    // Relasi ke tabel kritik
    public function kritikSaran()
    {
        return $this->hasMany(KritikSaran::class, 'id_user');
    }

    // Relasi ke tabel pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_user');
    }

    public function dibayar()
    {
        return $this->hasMany(Dibayar::class, 'id_user');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nik',
        'n_pegawai',
        't_lahir',
        'd_lahir',
        'jk',
        'rt',
        'rw',
        'telp',
        'kelurahan_id',
        'foto',
        'user_id',
        'alamat',
    ];
}

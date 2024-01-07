<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'n_pegawai',
        'telp',
        'email',
        'foto',
        'user_id',
    ];
}

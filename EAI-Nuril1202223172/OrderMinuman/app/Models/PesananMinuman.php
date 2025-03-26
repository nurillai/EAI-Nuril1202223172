<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananMinuman extends Model
{
    use HasFactory;

    protected $table = 'pesanan_minuman';

    protected $fillable = [
        'nama_pemesan',
        'jenis_minuman',
        'suhu',
        'gula'
    ];
}

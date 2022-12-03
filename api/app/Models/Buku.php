<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penulis',
        'id_genre',
        'judul',
        'sinopsis',
        'halaman',
        'penerbit',
        'isbn',
        'bahasa',
        'tgl_terbit',
        'stok',
        'cover'
    ];
}

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

    public $rules = [
        'id_penulis' => 'required',
        'id_genre' => 'required',
        'judul' => 'required',
        'sinopsis' => 'required',
        'halaman' => 'required',
        'penerbit' => 'required',
        'isbn' => 'required',
        'bahasa' => 'required',
        'tgl_terbit' => 'required',
        'stok' => 'required',
        'cover' => 'required'
    ];
}

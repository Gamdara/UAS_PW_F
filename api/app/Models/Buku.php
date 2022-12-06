<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'penulis_id',
        'genre_id',
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

    public static $rules = [
        "penulis_id" => "required",
        "genre_id" => "required",
        "judul" => "required",
        "sinopsis" => "required",
        "halaman" => "required",
        "penerbit" => "required",
        "isbn" => "required",
        "bahasa" => "required",
        "tgl_terbit" => "required",
        "stok" => "required",
        "cover" => "required"
    ];

    public function genre()
    {
        return $this->hasOne(Genre::class, 'id');
    }

    public function penulis()
    {
        return $this->hasOne(Penulis::class, 'id');
    }
}

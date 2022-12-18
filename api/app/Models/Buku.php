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
        'harga',
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
        'harga' => 'required',
        "judul" => "required",
        "sinopsis" => "required",
        "halaman" => "required",
        "penerbit" => "required",
        "isbn" => "required",
        "bahasa" => "required",
        "tgl_terbit" => "required",
        "stok" => "required"
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function penulis()
    {
        return $this->belongsTo(Penulis::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    protected $appends = [
        'rating'
    ];

    function getRatingAttribute(){
        return round($this->review->avg('nilai'),1);
    }
    
}

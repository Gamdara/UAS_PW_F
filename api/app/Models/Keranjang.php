<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah'
    ];

    public static $rules = [
        'buku_id' => 'required',
        'jumlah' => 'required',
    ];

    public function buku(){
        return $this->belongsTo(Buku::class);
    }
}

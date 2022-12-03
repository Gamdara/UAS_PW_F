<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_buku',
        'jumlah'
    ];

    public $rules = [
        'id_user' => 'required',
        'id_buku' => 'required',
        'jumlah' => 'required',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_transaksi',
        'id_buku',
        'jumlah',
        'subtotal'
    ];

    public static $rules = [
        'id_transaksi' => 'required',
        'id_buku'  => 'required',
        'jumlah' => 'required',
        'subtotal' => 'required'
    ];
}
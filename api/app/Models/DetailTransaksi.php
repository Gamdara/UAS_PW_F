<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaksi_id',
        'buku_id',
        'jumlah',
        'subtotal'
    ];

    public static $rules = [
        'transaksi_id' => 'required',
        'buku_id'  => 'required',
        'jumlah' => 'required',
        'subtotal' => 'required'
    ];

    public function bukus(){
        return $this->belongsTo(Buku::class,'buku_id','id');
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}

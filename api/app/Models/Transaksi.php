<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'total'
    ];

    public static $rules = [
        'user_id' => 'required',
        'tanggal' => 'required|date',
        'total' => 'required'
    ];

    public function details(){
        return $this->hasMany(DetailTransaksi::class);
    }
}

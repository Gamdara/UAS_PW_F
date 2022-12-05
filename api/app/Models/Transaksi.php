<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'tanggal'
    ];

    public static $rules = [
        'id_user' => 'required',
        'tanggal' => 'required',
    ];
}

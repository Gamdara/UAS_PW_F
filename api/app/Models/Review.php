<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_buku',
        'id_user',
        'nilai',
        'komentar',
    ];

    public static $rules = [
        'id_buku' => 'required',
        'id_user' => 'required',
        'nilai' => 'required',
        'komentar' => 'required',
    ];
}

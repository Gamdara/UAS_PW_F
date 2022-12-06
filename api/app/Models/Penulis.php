<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tgl_lahir',
        'asal',
    ];

    public static $rules = [
        "nama" => "required",
        "tgl_lahir" => "required",
        "asal" => "required",
    ];
}

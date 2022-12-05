<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nama',
        'tgl_lahir',
        'asal',
    ];

    public static $rules = [
        'id' => 'required',
        'nama' => 'required',
        'tgl_lahir' => 'required',
        'asal' => 'required',
    ];
}

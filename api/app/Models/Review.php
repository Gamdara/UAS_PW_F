<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'buku_id',
        'user_id',
        'nilai',
        'komentar',
    ];

    public static $rules = [
        'buku_id' => 'required',
        'nilai' => 'required'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

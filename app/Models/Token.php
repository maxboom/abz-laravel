<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'expires_at'];

    public $timestamps = false;

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

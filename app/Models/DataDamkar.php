<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDamkar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'latitude',
        'longitude',
        'alamat',
    ];
}

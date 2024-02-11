<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_sensor',
        'nama',
        'latitude',
        'longitude',
        'tempat_sensor',
        'alamat',
        'status',
    ];
}

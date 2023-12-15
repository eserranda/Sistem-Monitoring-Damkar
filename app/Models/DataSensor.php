<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSensor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'kode_sensor',
        'latitude',
        'longitude',
        'tempat_sensor',
        'alamat',
    ];
}

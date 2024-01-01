<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'apiKey',
        'sensor_api',
        'sensor_gas',
        'sensor_suhu',
        'sensor_asap'
    ];
}

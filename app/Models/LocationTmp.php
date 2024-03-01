<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationTmp extends Model
{
    use HasFactory;

    protected $fillable = [
        'apiKey',
        'latitude',
        'longitude',
        'mode'
    ];
}

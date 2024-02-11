<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataDamkar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_damkar',
        'nama',
        'latitude',
        'longitude',
        'alamat',
        'status',
    ];

    function damkar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_damkar', 'id');
    }
}

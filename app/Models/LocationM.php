<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationM extends Model
{
    protected $table = 'location';

    protected $fillable = [
        'latitude',
        'longitude',
        'jarak',
        'alamat',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voltage extends Model
{
    protected $table = 'voltages';

    protected $fillable = [
        'user_id',
        'mac_address',
        'voltage',
        'date',
    ];
}

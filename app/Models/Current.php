<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Current extends Model
{
    protected $table = 'currents';

    protected $fillable = [
        'user_id',
        'mac_address',
        'current',
        'date',
        'only_date',
    ];
}

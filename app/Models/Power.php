<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
   protected $table = 'powers';

   protected $fillable = [
        'user_id',
        'mac_address',
        'power',
        'date',
    ];
}

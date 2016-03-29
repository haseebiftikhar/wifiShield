<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MacAddress extends Model
{
    protected $table = 'macaddreses';

    protected $fillable = [
        'user_id',
        'mac_address',
    ];
}

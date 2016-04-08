<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class MacAddress extends Model implements AuthenticatableContract
{
	use Authenticatable;

    protected $table = 'macaddreses';

    protected $fillable = [
        'user_id',
        'mac_address',
        'device_name',
    ];
}

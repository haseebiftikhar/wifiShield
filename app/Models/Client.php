<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Client extends Model implements AuthenticatableContract
{
	use Authenticatable;


	protected $table = 'clients';

	protected $fillable = [
        'email',
        'username',
        'password',
        'api_key',
        'confirmed',
        'confirmation_code',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name}"." "."{$this->last_name}";
        }

        if ($this->first_name) {
            return $this->first_name;
        }
        return null;
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?:$this->username;
    }

    public function getFirstNameOrUsername()
    {
        return $this->first_name ?:$this->username;
    }
}

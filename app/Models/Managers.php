<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Managers extends Authenticatable
{
    protected $table = 'managers';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_user', 'id_group',
    ];

    public function Managers_User()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_user');
    }
}

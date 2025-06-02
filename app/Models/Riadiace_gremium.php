<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Riadiace_gremium extends Authenticatable
{
    protected $table = 'riadiace_gremium';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_user',
    ];

    public function RiadiaceGremium_User()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_user');
    }
}

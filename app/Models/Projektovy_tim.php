<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Projektovy_tim extends Authenticatable
{
    protected $table = 'projektovy_tim';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_user',
    ];

    public function ProjektovyTim_User()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_user');
    }

    public function ProjektovyTim_UserGroup()
    {
        return $this->hasOne('App\Models\Users_group', 'id_user', 'id_user')->whereNotNull('group');
    }
}

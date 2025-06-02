<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Projektovy_manazer_pp extends Authenticatable
{
    protected $table = 'projektovy_manazer_pp';
    use Notifiable;
    use SoftDeletes;
    //use Versionable;
    protected $versionable = ['id_pp', 'id_user'];

    protected $fillable = [
        'id_pp', 'id_user',
    ];

    public function ProjektovyManagerPP_User()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_user');
    }

    public function ProjektovyManagerPP_UserGroups()
    {
        return $this->hasOne('App\Models\Users_group', 'user_id', 'id_user')->whereNotNull('group')->whereNull('group_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Organizacia_projektu extends Authenticatable
{
    protected $table = 'organizacia_projektu';
    use Notifiable;
    use SoftDeletes;
    use Versionable;

    protected $versionable = ['externi_stakeholderi'];

    protected $fillable = [
        'id_pp', 'id_zadavatel_projektu', 'id_projektovy_garant', 'externi_stakeholderi', 'id_politicky_garant', 'id_magistratny_garant',
    ];

    public function OrganizaciaProjektu_Groups_Zadavatel()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'id_zadavatel_projektu');
    }

    public function OrganizaciaProjektu_User_Garant()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_projektovy_garant');
    }

    public function OrganizaciaProjektu_User_PolitickyGarant()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_politicky_garant');
    }

    public function OrganizaciaProjektu_User_MagistratnyGarant()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_magistratny_garant');
    }


}

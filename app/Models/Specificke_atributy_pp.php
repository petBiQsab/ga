<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Specificke_atributy_pp extends Authenticatable
{
    protected $table = 'specificke_atributy_pp';
    use Notifiable;
    use SoftDeletes;
    use Versionable;

    protected $versionable = ['id_pp', 'id_speci_atribut'];

    protected $fillable = [
        'id_pp', 'id_speci_atribut',
    ];

    public function SpeciAtributPP_SpeciAtribut()
    {
        return $this->hasOne('App\Models\Specificke_atributy', 'id', 'id_speci_atribut');
    }
}

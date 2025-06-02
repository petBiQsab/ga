<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Typ_projektu_pp extends Authenticatable
{
    protected $table = 'typ_projektu_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_typ_projektu',
    ];

    public function TypProjektuPP_TypProjektu()
    {
        return $this->hasOne('App\Models\Typ_projektu', 'id', 'id_typ_projektu');
    }
}

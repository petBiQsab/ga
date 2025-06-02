<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aktivity_zodpovedne_osoby extends Authenticatable
{
    protected $table = 'aktivity_zodpovedne_osoby';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_aktivity_pp', 'id_user',
    ];

    public function AktivityZodpovedneOsoby_User()
    {
        return $this->hasOne('App\Models\User', 'objectguid', 'id_user');
    }
}

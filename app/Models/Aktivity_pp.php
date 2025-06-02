<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aktivity_pp extends Authenticatable
{
    protected $table = 'aktivity_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_aktivita', 'vlastna_aktivita', 'id_kategoria', 'zaciatok_aktivity', 'skutocny_zaciatok_aktivity', 'koniec_aktivity', 'skutocny_koniec_aktivity',
    ];

    public function AktivityPP_Aktivity()
    {
        return $this->hasOne('App\Models\Aktivity', 'id', 'id_aktivita');
    }

    public function AktivityPP_AktivityZodpovedneOsoby()
    {
        return $this->hasMany('App\Models\Aktivity_zodpovedne_osoby', 'id_aktivity_pp', 'id');
    }

    public function AktivityPP_Kategoria()
    {
        return $this->hasOne('App\Models\Aktivita_Kategoria','id', 'id_kategoria');
    }

    public function ZodpovedneOsoby(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'aktivity_zodpovedne_osoby', 'id_aktivity_pp', 'id_user');
    }

}

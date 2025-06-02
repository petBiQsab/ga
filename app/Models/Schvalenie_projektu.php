<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Schvalenie_projektu extends Authenticatable
{
    protected $table = 'schvalenie_projektu';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'datum_schvalenia_ID', 'id_schvalenie_pi_na_pg', 'datum_schvalenia_pi_na_pg', 'hyperlink_na_pi', 'pripomienky_k_pi', 'id_schvalenie_pz_na_pg', 'datum_schvalenia_pz_na_pg', 'hyperlink_na_pz', 'pripomienky_k_pz', 'datum_schvalenia_projektu_ppp', 'datum_schvalenia_projektu_msz',
    ];

    public function SchvalovanieProjektu_AkceptaciaPIPG()
    {
        return $this->hasOne('App\Models\Akceptacia', 'id', 'id_schvalenie_pi_na_pg');
    }

    public function SchvalovanieProjektu_AkceptaciaPZPG()
    {
        return $this->hasOne('App\Models\Akceptacia', 'id', 'id_schvalenie_pz_na_pg');
    }
}


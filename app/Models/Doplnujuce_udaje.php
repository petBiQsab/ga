<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Doplnujuce_udaje extends Authenticatable
{
    protected $table = 'doplnujuce_udaje';
    use Notifiable;
    //use SoftDeletes;
    use Versionable;

    protected $versionable = ['hyperlink_na_ulozisko_projektu'];

    protected $fillable = [
        'id_pp', 'id_externe_financovanie', 'zdroj_externeho_financovania', 'suma_externeho_financovania', 'podiel_externeho_financovania_z_celkovej_ceny', 'id_priorita', 'id_priorita_new', 'id_verejna_praca', 'hyperlink_na_ulozisko_projektu'
    ];

    public function Doplnujuce_udaje_PrioritaNew()
    {
        return $this->hasOne('App\Models\Priorita', 'id', 'id_priorita_new');
    }

    public function Doplnujuce_udaje_Priorita()
    {
        return $this->hasOne('App\Models\Politicka_priorita', 'id', 'id_priorita');
    }

    public function Doplnujuce_udaje_ExterneFinancovanie()
    {
        return $this->hasOne('App\Models\Externe_financovanie', 'id', 'id_externe_financovanie');
    }

    public function Doplnujuce_udaje_VerejnaPraca()
    {
        return $this->hasOne('App\Models\Verejna_praca', 'id', 'id_verejna_praca');
    }
}

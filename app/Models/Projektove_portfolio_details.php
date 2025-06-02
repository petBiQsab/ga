<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Projektove_portfolio_details extends Authenticatable
{
    protected $table = 'projektove_portfolio_details';
    use Notifiable;
    use SoftDeletes;
    //use Versionable;

    protected $versionable = ['id_kategoria_projektu', 'datum_zacatia_projektu', 'datum_konca_projektu', 'id_stav_projektu', 'id_faza_projektu', 'planovane_aktivity_na_najblizsi_tyzden', 'zrealizovane_aktivity', 'rizika_projektu', 'poznamky', 'id_ryg', 'id_muscow','najaktualnejsia_cena_projektu_vrat_DPH', 'najaktual_rocne_prevadzkove_naklady_projektu_vrat_DPH'];

    protected $fillable = [
        'id_pp', 'ciel_projektu', 'meratelny_vystupovy_ukazovatel', 'id_kategoria_projektu', 'id_stav_projektu', 'id_faza_projektu', 'datum_zacatia_projektu', 'datum_konca_projektu', 'rizika_projektu', 'zrealizovane_aktivity', 'planovane_aktivity_na_najblizsi_tyzden', 'najaktualnejsia_cena_projektu_vrat_DPH', 'najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH', 'poznamky', 'poznamky_pm',
    ];

    public function PP_Details_Kategoria()
    {
        return $this->hasOne('App\Models\Kategoria', 'id', 'id_kategoria_projektu');
    }

    public function PP_Details_Stav_projektu()
    {
        return $this->hasOne('App\Models\Stav_projektu', 'id', 'id_stav_projektu');
    }

    public function PP_Details_Faza_projektu()
    {
        return $this->hasOne('App\Models\Faza_projektu', 'id', 'id_faza_projektu');
    }

    public function PP_Details_Ryg()
    {
        return $this->hasOne('App\Models\RYG', 'id', 'id_ryg');
    }

    public function PP_Details_Muscow()
    {
        return $this->hasOne('App\Models\Muscow', 'id', 'id_muscow');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Export_dataset extends Authenticatable
{
    protected $table = 'export_dataset';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp','week_number','status','rizika_projektu','zrealizovane_aktivity',
        'planovane_aktivity_na_najblizsi_tyzden','komentar','datum_zacatia_projektu',
        'datum_konca_projektu','najaktualnejsia_cena_projektu_vrat_DPH',
        'najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH',
        'suma_externeho_financovania','zdroj_externeho_financovania','ryg','muscow',
        'faza_projektu','status_projektu',
    ];
}

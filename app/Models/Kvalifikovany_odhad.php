<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kvalifikovany_odhad extends Authenticatable
{
    protected $table = 'kvalifikovany_odhad';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'kvalifikovany_odhad_ceny_projektu', 'kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph', 'zdroj_info_kvalif_odhad',
    ];


}

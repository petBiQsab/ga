<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Projektovy_zamer extends Authenticatable
{
    protected $table = 'projektovy_zamer';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'celkom_vrat_dph', 'rocne_prevadzkove_naklady_vrat_dph', 'zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph', 'zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph', 'bezne_prijmy_celkom_vrat_dph', 'kapitalove_prijmy_celkom_vrat_dph',
    ];


}

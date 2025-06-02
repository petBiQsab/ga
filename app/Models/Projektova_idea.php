<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Projektova_idea extends Authenticatable
{
    protected $table = 'projektova_idea';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'celkom_bv_a_kv_vrat_dph', 'rocne_prevadzkove_naklady_projektu_vrat_dph', 'idea_bezne_ocakavane_rocne_naklady_projektu_s_dph', 'idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph',
    ];



}

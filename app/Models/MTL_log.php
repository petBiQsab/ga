<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MTL_log extends Authenticatable
{
    protected $table = 'mtl_log';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'status','week_number', 'komentar', 'planovane_aktivity_na_najblizsi_tyzden',
        'zrealizovane_aktivity', 'rizika_projektu', 'created_at', 'updated_at', 'deleted_at'
    ];

}

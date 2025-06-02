<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kvalifikovany_odhad_roky extends Authenticatable
{
    protected $table = 'kvalifikovany_odhad_roky';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'rok', 'value',
    ];
}

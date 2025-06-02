<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Projektovy_zamer_roky extends Authenticatable
{
    protected $table = 'projektovy_zamer_roky';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'typ', 'rok', 'value',
    ];
}

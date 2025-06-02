<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mestska_cast_pp extends Authenticatable
{
    protected $table = 'mestska_cast_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_mc',
    ];

    public function MestkaCastPP_MestskaCast()
    {
        return $this->hasOne('App\Models\Mestska_cast', 'id', 'id_mc');
    }
}

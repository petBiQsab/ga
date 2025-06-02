<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Coop_utvary extends Authenticatable
{
    protected $table = 'coop_utvary';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_group',
    ];

    public function CoopUtvary_Groups()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'id_group')->whereNull('typ');;
    }
}

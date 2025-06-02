<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Coop_organizacie extends Authenticatable
{
    protected $table = 'coop_organizacie';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_group',
    ];

    public function CoopOrganizacie_Groups()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'id_group')->whereNotNull('typ');
    }
}

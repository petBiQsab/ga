<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sprava extends Authenticatable
{
    protected $table = 'sprava';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_group',
    ];

    public function Sprava_Groups()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'id_group');
    }


}

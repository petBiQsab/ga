<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aktivity extends Authenticatable
{
    protected $table = 'aktivity';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'id_kategoria', 'flag', 'note',
    ];

    public function Aktivity_Kategoria()
    {
        return $this->hasOne('App\Models\Aktivita_Kategoria','id', 'id_kategoria');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Suvisiace_projekty extends Authenticatable
{
    protected $table = 'suvisiace_projekty';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_suvis_projekt',
    ];

    public function SuvisiaceProjekty_PP()
    {
        return $this->hasOne('App\Models\Projektove_portfolio', 'id_original', 'id_suvis_projekt');
    }

}

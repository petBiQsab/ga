<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Phsr_pp extends Authenticatable
{
    protected $table = 'phsr_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_phsr',
    ];

    public function PP_PHSR_Strateg_ciel()
    {
        return $this->hasOne('App\Models\Phsr', 'id', 'id_phsr')->where(['type' => 'Strategický cieľ']);
    }

    public function PP_PHSR_Speci_ciel()
    {
        return $this->hasOne('App\Models\Phsr', 'id', 'id_phsr')->where(['type' => 'Špecifický cieľ']);
    }

    public function PP_PHSR_Program()
    {
        return $this->hasOne('App\Models\Phsr', 'id', 'id_phsr')->where(['type' => 'Program']);
    }
}

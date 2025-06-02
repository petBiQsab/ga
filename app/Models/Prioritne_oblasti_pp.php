<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Prioritne_oblasti_pp extends Authenticatable
{
    protected $table = 'prioritne_oblasti_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_prioritne_oblasti',
    ];

    public function PrioritneOblastiPP_PrioritneOblasti()
    {
        return $this->hasOne('App\Models\Prioritne_oblasti', 'id', 'id_prioritne_oblasti');
    }
}

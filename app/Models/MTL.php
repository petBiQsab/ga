<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class MTL extends Authenticatable
{
    protected $table = 'mtl';
    use Notifiable;
    use SoftDeletes;
    use Versionable;

    protected $versionable = ['status', 'komentar'];

    protected $fillable = [
        'id_pp', 'status', 'history', 'reset', 'komentar', 'status_user',
    ];

    public function MTL_PP_Details()
    {
        return $this->hasOne('App\Models\Projektove_portfolio_details', 'id_pp', 'id_pp');
    }

    public function MTL_Doplnujuce_udaje()
    {
        return $this->hasOne('App\Models\Doplnujuce_udaje', 'id_pp', 'id_pp');
    }
}

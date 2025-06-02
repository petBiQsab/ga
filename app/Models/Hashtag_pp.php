<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hashtag_pp extends Authenticatable
{
    protected $table = 'hashtag_pp';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_pp', 'id_hashtag',
    ];

    public function HashtagPP_Hashtag()
    {
        return $this->hasOne('App\Models\Hashtag', 'id', 'id_hashtag');
    }
}

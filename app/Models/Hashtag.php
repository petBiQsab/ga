<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Hashtag extends Authenticatable
{
    protected $table = 'hashtag';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class RYG extends Authenticatable
{
    use SoftDeletes;
    use Versionable;

    protected $table = 'ryg';

    protected $versionable = ['id','value'];
    protected $fillable = [
        'value',
    ];
}


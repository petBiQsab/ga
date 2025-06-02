<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Specificke_atributy extends Authenticatable
{
    protected $table = 'specificke_atributy';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}


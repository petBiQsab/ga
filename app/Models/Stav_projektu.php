<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Stav_projektu extends Authenticatable
{
    protected $table = 'stav_projektu';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

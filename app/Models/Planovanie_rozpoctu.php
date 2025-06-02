<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Planovanie_rozpoctu extends Authenticatable
{
    protected $table = 'planovanie_rozpoctu';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

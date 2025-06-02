<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Faza_projektu extends Authenticatable
{
    protected $table = 'faza_projektu';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

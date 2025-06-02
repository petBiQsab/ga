<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Politicka_priorita extends Authenticatable
{
    protected $table = 'politicka_priorita';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

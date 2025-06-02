<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Priorita extends Authenticatable
{
    protected $table = 'priorita';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

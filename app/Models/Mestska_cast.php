<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mestska_cast extends Authenticatable
{
    protected $table = 'mestska_cast';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

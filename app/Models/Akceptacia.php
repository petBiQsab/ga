<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akceptacia extends Authenticatable
{
    protected $table = 'akceptacia';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];

}

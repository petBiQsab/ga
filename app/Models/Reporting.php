<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reporting extends Authenticatable
{
    protected $table = 'reporting';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value'
    ];
}

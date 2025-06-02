<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kategoria extends Authenticatable
{
    protected $table = 'kategoria';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Verejna_praca extends Authenticatable
{
    protected $table = 'verejna_praca';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Prioritne_oblasti extends Authenticatable
{
    protected $table = 'prioritne_oblasti';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

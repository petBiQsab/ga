<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Phsr extends Authenticatable
{
    protected $table = 'phsr';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value', 'type',
    ];
}

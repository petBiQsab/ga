<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Externe_financovanie extends Authenticatable
{
    protected $table = 'externe_financovanie';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'value',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aktivita_Kategoria extends Authenticatable
{
    protected $table = 'aktivita_kategoria';
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'value','orderNum'
    ];
}

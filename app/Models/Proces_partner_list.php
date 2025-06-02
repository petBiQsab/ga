<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Proces_partner_list extends Authenticatable
{
    protected $table = 'procesny_partner_list';
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_user',
    ];
}

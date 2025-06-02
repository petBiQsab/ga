<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Overtrue\LaravelVersionable\Versionable;

class Muscow extends Authenticatable
{
    use SoftDeletes;
    use Versionable;

    protected $versionable = ['value'];
    protected $table = 'muscow';

    protected $fillable = [
        'value',
    ];
}

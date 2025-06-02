<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activeUser',
        'checksum',
        'department',
        'email',
        'givenName',
        'jobTitle',
        'name',
        'objectguid',
        'password',
        'role',
        'sn',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
        // TODO: Implement getActivitylogOptions() method.
    }

    public function User_User_Groups()
    {
        return $this->hasOne('App\Models\Users_group', 'user_id', 'objectguid')->whereNull('group_id');
    }

    public function MTL()
    {
        return $this->hasOne(MTL::class, 'id_pp', 'id'); // Adjust the column names accordingly
    }

    public function Projektove_portfolio()
    {
        return $this->hasMany(Projektove_portfolio::class, 'user_id', 'id'); // Adjust the column names accordingly
    }
}

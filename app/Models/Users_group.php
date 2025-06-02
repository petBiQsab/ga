<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users_group extends Authenticatable
{
    protected $table = 'user_groups';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'group', 'group_id',
    ];

    public function UsersGroup_Group()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'group');
    }

    public function UsersGroup_Manager()
    {
        return $this->hasOne('App\Models\Managers', 'id_group', 'group');
    }

    public function sekciaName()
    {
        return $this->hasOne('App\Models\Groups', 'objectguid', 'group_id')->orderBy('cn');
    }

    public function Users_groupParentName()
    {
        return $this->belongsTo(Groups::class, 'group_id', 'objectguid')->orderBy('cn');
    }

    public function Users_groupGroupName()
    {
        return $this->belongsTo(Groups::class, 'group', 'objectguid')->orderBy('cn');
    }



}

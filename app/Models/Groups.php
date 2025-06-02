<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Groups extends Authenticatable
{
    protected $table = 'groups';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cn', 'skratka', 'objectguid', 'typ', 'ico', 'gestor_utvar', 'checksum'
    ];


    public function user_groups()
    {
        return $this->hasOne('App\Models\Users_group', 'group_id', 'objectguid')->orderBy('cn');
    }

    public function user_groups2()
    {
        return $this->hasOne('App\Models\Users_group', 'group', 'objectguid')->orderBy('cn');
    }

    public function userGroups()
    {
        return $this->hasMany(Users_group::class, 'group_id');
    }

    // Recursive function to get all child groups
    public function getSubgroups($groupId, &$result)
    {
        $subgroups = $this->userGroups()->where('group_id', $groupId)->pluck('group')->toArray();

        foreach ($subgroups as $subgroup) {
            $result[] = $subgroup;
            $this->getSubgroups($subgroup, $result);
        }
    }

    public function getGroupsAtOrBelowUserLevel($userId)
    {
        $result = [];

        // Retrieve immediate child groups for the given user_id
        $subgroups = $this->userGroups()->where('user_id', $userId)->pluck('group')->toArray();

        foreach ($subgroups as $subgroup) {
            $result[] = $subgroup;
            $this->getSubgroups($subgroup, $result);
        }

        return array_unique($result);
    }

}

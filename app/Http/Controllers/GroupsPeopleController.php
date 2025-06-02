<?php


namespace App\Http\Controllers;


use Adldap\Laravel\Facades\Adldap;

use App\Http\Controllers\Interfaces\Admin\AdminDataInterface;
use App\Models\Groups;
use App\Models\Managers;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\TestingGroups;
use App\Models\TestingUsers;
use App\Models\User;
use App\Models\UserGroupsTest;
use App\Models\Users_group;
use App\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mail;
use function Symfony\Component\String\b;

class GroupsPeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function searchUsers()
    {

        $adldap = Adldap::getFacadeRoot();
        $provider=$adldap->getDefaultProvider();

        $recordsPerPage = 1000;
        $currentPage = 1;

        $users=$provider->search()->select('displayName','mail','objectguid')->where('objectCategory','=','CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->paginate(900)->getResults(); //AD users
//        $users=$provider->search()->select('*')->where('objectCategory','=','CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->paginate(900)->getResults(); //AD users

//        $users=$provider->search()->select('displayName','mail','objectguid')->where('objectCategory','=','CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->get(); //AD users
        foreach ($users as $user) //add new users to array, then insert into DB
        {


//                if($user['mail'][0]=="marcel.varenits@bratislava.sk")
//                {
//                    dd($user);
//                }
            if ((isset($user['mail'][0])) or isset($user['extensionName'][0])) {

                $mail="";
                if(empty($user['mail'][0]))
                {
                    $mail=$user['extensionName'][0];
                }
                else{
                    $mail= $user['mail'][0];
                }
                if ($user['displayName'][0]=="Hlavačková Jana, Mgr.")
                {
                    $data = array(
                        'name' => $user['displayName'][0],
                        'email' => $mail,
                        'objectguid' => $user->getConvertedGuid(),

                    );
//                    dd($data);
                }
                $data = array(
                    'name' => $user['displayName'][0],
                    'email' => $mail,
                    'objectguid' => $user->getConvertedGuid(),

                );
                $insert_data[] = $data;
            }
        }
    }

    public function importUsers()
    {
        User::truncate();
        $adldap = Adldap::getFacadeRoot();
        $provider=$adldap->getDefaultProvider();

        $processedEmails = [];
        $users=$provider->search()->select('name','mail','objectguid','personalTitle','generationQualifier','givenName','sn','title','department','description','extensionName','distinguishedName')->where('objectCategory','=','CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->paginate(900)->getResults(); //AD users
        foreach ($users as $user) //add new users to array, then insert into DB
        {
            if ((isset($user['mail'][0])) or isset($user['extensionName'][0])) {
                $mail="";
                if(empty($user['mail'][0]))
                {
                    $mail=$user['extensionName'][0];
                }
                else{
                    $mail= $user['mail'][0];
                }
                if (!isset($user['title'][0]))
                {
                    $jobTitle=null;
                }else{
                    $jobTitle=$user['title'][0];
                }
                if (!isset($user['givenName'][0]))
                {
                    $givenName=null;
                }else{
                    $givenName=$user['givenName'][0];
                }
                if (!isset($user['sn'][0]))
                {
                    $sn=null;
                }else{
                    $sn=$user['sn'][0];
                }
                if (!isset($user['name'][0]))
                {
                    $name=null;
                }else{
                    $name=$user['name'][0];
                }
                if (!isset($user['department'][0]))
                {
                    $department=null;
                }else{
                    $department=$user['department'][0];
                }

                if (!isset($user['distinguishedName'][0]))
                {
                    $distinguishedName=null;
                }else{
                    $distinguishedName=$user['distinguishedName'][0];
                }
                if (!str_contains($distinguishedName,"OU=MagistratBA") and !str_contains($distinguishedName,"OU=Organizacie") and !str_contains($distinguishedName,"OU=MPP") and !str_contains($distinguishedName,"OU=Odideni") and !str_contains($distinguishedName,"OU=MP"))
                {
                    continue;
                }

                if (in_array($mail, $processedEmails)) {
                    continue; // Skip this iteration if the email is already processed
                }
                $data = array(
                    'name' => $name,
                    'sn' => $sn,
                    'givenName' => $givenName,
                    'email' => $mail,
                    'objectguid' => $user->getConvertedGuid(),
                    'department' => $department,
                    'jobTitle' => $jobTitle,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                    //   'personalTitle' => $user['personalTitle'][0],
                    //   'generationQualifier' => $user['generationQualifier'][0],
                );
                $insert_data[] = $data;
                $processedEmails[] = $mail;
            }
        }
        User::insert($insert_data);
    }


    public function importGroups()
    {
        Groups::truncate();
        $adldap = Adldap::getFacadeRoot();
        $provider=$adldap->getDefaultProvider();

        $groups=$provider->search()->select('cn','objectguid','info','extensionName','description')->where('objectCategory','=','CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->get(); //AD users
        foreach ($groups as $group)
        {
            if(str_contains($group['distinguishedname'][0],"OU=Struktura pre WEB") or str_contains($group['distinguishedname'][0],"OU=OU-Organizacie") or str_contains($group['distinguishedname'][0],"OU=Struktura-ine"))
            {
                if (!isset($group['cn'][0]))
                {
                    $cn=null;
                }else{
                    $cn=$group['cn'][0];
                }
                if (!isset($group['extensionName'][0]))
                {
                    $extensionName=null;
                }else{
                    $extensionName=$group['extensionName'][0];
                }
                if (!isset($group['info'][0]))
                {
                    $info=null;
                }else{
                    if (str_contains($group['distinguishedname'][0],"OU=OU-Organizacie"))
                    {
                        $info=$group['info'][0];
                    }
                    else $info=null;
                }

                if (isset($group['description'][0]) && is_numeric($group['description'][0]))
                {
                    $ico=$group['description'][0];


                }else{
                    $ico=null;
                }

                $data = array(
                    'cn'=>$cn,
                    'skratka'=> $extensionName,
                    'objectguid' =>$group->getConvertedGuid(),
                    'typ'=>$info,
                    'ico'=>$ico,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                );
                $insert_data[] = $data;
            }
        }
        Groups::insert($insert_data);
    }

    public function importStructure()
    {
        Users_group::truncate();

        $adldap = Adldap::getFacadeRoot();
        $provider=$adldap->getDefaultProvider();

        $groups=$provider->search()->select('description','distinguishedname','member','objectguid')->where('objectCategory','=','CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->get(); //AD users
        $insert_data=[];

        foreach ($groups as $group) {

            if (strpos($group['distinguishedname'][0], 'OU=Struktura pre WEB') or strpos($group['distinguishedname'][0], 'OU=OU-Organizacie')) {
                $groupId = $group->getConvertedGuid();

                if (is_array($group['member']) || is_object($group['member'])) {
                    foreach ($group['member'] as $member) {
                        {
                            if (!strpos($member, 'OU=Struktura pre WEB')) {

                                $user = $provider->search()->select('objectguid')->where('distinguishedname', '=', $member)->where('objectCategory', '=', 'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->paginate(900)->getResults(); //AD users
                                if (isset($user[0]))
                                {
                                    $userDB = User::where(['objectguid' => $user[0]->getConvertedGuid()])->first();

                                    if ($userDB === null) {
                                        continue;
                                    }

                                    $data = array(
                                        'user_id' => $userDB->objectguid,
                                        'group' => $groupId,
                                        'group_id' => null,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    );

                                    $insert_data[]=$data;
                                }

                            } elseif (strpos($member, 'OU=Struktura pre WEB') or strpos($member, 'OU=OU-Organizacie')) {
                                $tmp = explode("CN=", $member);
                                $tmp = explode(",OU", $tmp[1]);
                                $result = $tmp[0];
                                $groupDB = Groups::where('cn', 'like', '%' . $result . '%')->first();
                                if ($groupDB['objectguid'] == null) {
                                    $groupDB['objectguid'] = "";
                                }

                                $data = array(
                                    'user_id' => null,
                                    'group' => $groupDB->objectguid,
                                    'group_id' => $groupId,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                );
                                $insert_data[]=$data;
                            }
                        }
                    }

                }
            }
        }
        Users_group::insert($insert_data);
    }

    public function importManagers()
    {
        Managers::truncate();
        $adldap = Adldap::getFacadeRoot();
        $provider=$adldap->getDefaultProvider();

        $groups=$provider->search()->select('cn','objectguid','managedBy','distinguishedname','member')->where('objectCategory','=','CN=Group,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->get(); //AD users
        foreach ($groups as $group)
        {
            if(str_contains($group['distinguishedname'][0],"OU=Struktura pre WEB"))
            {
                if (isset($group['managedBy'][0]))
                {
                    $user = $provider->search()->select('objectguid')->where('distinguishedname', '=', $group['managedBy'][0])->where('objectCategory', '=', 'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->paginate(900)->getResults(); //AD users
                    $userDB = User::where(['objectguid' => $user[0]->getConvertedGuid()])->first();
                    if ($userDB === null) {
                        continue;
                    }

                    $data = array(
                        'id_user' => $userDB->objectguid,
                        'id_group' => $group->getConvertedGuid(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );

                    $insert_data[]=$data;
                }
            }
        }
        Managers::insert($insert_data);
    }

    public function test()
    {



    }







//        $users=User::orderBy('department')->pluck('objectguid')->toArray();
//        $userRR=Users_group::pluck('user_id')->toArray();
//
//        $diff=array_diff($users,$userRR);
//
//        $diff=User::select(['name','department','objectguid'])->whereIn('objectguid',$diff)->get();
//
//        $diffArr=[];
//        foreach ($diff as $item)
//        {
//            $diffArr[]=$item->name." - ".$item->department." - ".$item->objectguid;
//
//        }
//        dd($diffArr);

    public function updatedb()
    {
        Schema::disableForeignKeyConstraints();
        $this->importUsers();
        $this->importGroups();
        $this->importStructure();
        $this->importManagers();
        Schema::enableForeignKeyConstraints();
    }


}

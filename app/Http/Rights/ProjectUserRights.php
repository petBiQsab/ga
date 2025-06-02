<?php

namespace App\Http\Rights;

use Adldap\Laravel\Facades\Adldap;
use App\Models\Admin_list;
use App\Models\Managers;
use App\Models\Organizacia_projektu;
use App\Models\Proces_partner_list;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\Projektovy_tim;
use App\Models\Riadiace_gremium;
use App\Models\User;

class ProjectUserRights
{


    public function getStaticRole($id_user)
    {
        $userRoleRights = new \stdClass();

        $proces_partner = Proces_partner_list::where(['id_user' => $id_user])->first();
        $admin = Admin_list::where(['id_user' => $id_user])->first();

        if ($proces_partner !== null || $admin !== null) {

            if ($proces_partner !== null) {
                $userRoleRights->name = "Procesný partner";
                $userRoleRights->slug = "procesny_partner";
                return $userRoleRights;
            }

            if ($admin !== null) {
                $userRoleRights->name = "Administrátor";
                $userRoleRights->slug = "admin";
                return $userRoleRights;
            }
        } elseif ($proces_partner === null && $admin === null) {
            $userRoleRights->name = "Dynamická rola";
            $userRoleRights->slug = "dynamic";
            return $userRoleRights;
        }
    }

    public function getRightsForProject($id_user, $id_projekt)
    {
        $userRoleRights = new \stdClass();

        //STATIC ROLES
        if ($id_user=="80fcc719-c8ed-47ff-b67b-f40a8d7667f2") //peter.repka.admin@bratislava.sk
        {
            $userRoleRights->name = "Administrátor";
            $userRoleRights->slug = "admin";
            return $userRoleRights;
        }
        if ($id_user=="c8834fa4-c5bb-4755-95d9-807133f02a74") //peter.repka.supervizia@bratislava.sk
        {
            $userRoleRights->name="Supervízia projektov";
            $userRoleRights->slug="supervisor";
            return $userRoleRights;
        }
        if ($id_user=="ac2891d9-0fbf-446b-aa87-861da75798b3") //peter.repka.projektovytim@bratislava.sk
        {
            $userRoleRights->name="Projektový tím";
            $userRoleRights->slug="projekt_tim";
            return $userRoleRights;
        }
        if ($id_user=="899efb9b-dba0-4488-ab6b-1e4996796a52") //peter.repka.procesny@bratislava.sk
        {
            $userRoleRights->name="Procesný partner";
            $userRoleRights->slug="procesny_partner";
            return $userRoleRights;
        }
        if ($id_user=="f2306469-9eb9-4890-bf55-6d4d638b27f7") //peter.repka.pm@bratislava.sk
        {
            $userRoleRights->name="Projektové vedenie";
            $userRoleRights->slug="projekt_vedenie";
            return $userRoleRights;
        }
        if ($id_user=="4f2570b8-5288-4ad7-be6e-413c4e1a50bb") //peter.repka.everyone@bratislava.sk
        {
            $userRoleRights->name="Everyone";
            $userRoleRights->slug="everyone";
            return $userRoleRights;
        }

        $proces_partner = Proces_partner_list::where(['id_user' => $id_user])->first();
        $admin = Admin_list::where(['id_user' => $id_user])->first();

        if ($proces_partner !== null || $admin !== null) {

            if ($proces_partner !== null) {
                $userRoleRights->name = "Procesný partner";
                $userRoleRights->slug = "procesny_partner";
                return $userRoleRights;
            }

            if ($admin !== null) {
                $userRoleRights->name = "Administrátor";
                $userRoleRights->slug = "admin";
                return $userRoleRights;
            }
        } else {

            $adldap = Adldap::getFacadeRoot();
            $provider = $adldap->getDefaultProvider();

            $veduciProjektovehoManagera = Projektovy_manazer_pp::where(['id_pp' => $id_projekt])->get();
            if ($veduciProjektovehoManagera != null && count($veduciProjektovehoManagera) > 0) {

                $access = [];//zoznam nadriadených projektových managerov

                foreach ($veduciProjektovehoManagera as $item) {
                    if (isset($item->ProjektovyManagerPP_User->email)) {
                        $emailItem = $item->ProjektovyManagerPP_User->email;
                        $user = $provider->search()->select('manager')->where('objectCategory', '=', 'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->where('mail', '=', $emailItem)->paginate(900)->getResults(); //AD users
                        if ($user != null) {
                            if (isset($user[0]->manager[0])) {
                                $name = ltrim($user[0]->manager[0], 'CN=');
                                $name = explode(',OU', $name);
                                $name = str_replace("\,", ',', $name);
                                $managerOfManager = User::where(['name' => $name[0]])->first();
                                if ($managerOfManager != null) {
                                    $access[] = $managerOfManager->objectguid;
                                }
                            }
                        }
                    }
                }
                if (!empty($access)) {
                    if (in_array($id_user, $access)) {
                        $userRoleRights->name = "Supervízia projektov";
                        $userRoleRights->slug = "supervisor";
                        return $userRoleRights;
                    }
                }
            }

            $accessProjektTim = 0;
            $veduciProjektovehoTimu = Projektovy_tim::where(['id_pp' => $id_projekt])->get();

            if ($veduciProjektovehoTimu != null && count($veduciProjektovehoTimu) > 0) {
                $accessProjektTim = [];//zoznam nadriadených projektových managerov

                foreach ($veduciProjektovehoTimu as $item) {
                    if (isset($item->ProjektovyTim_User)) {
                    $emailItem = $item->ProjektovyTim_User->email;
                    $user = $provider->search()->select('manager')->where('objectCategory', '=', 'CN=Person,CN=Schema,CN=Configuration,DC=bratislava,DC=local')->where('mail', '=', $emailItem)->paginate(900)->getResults(); //AD users
                    if ($user != null) {
                        if (isset($user[0]->manager[0])) {

                            $name = ltrim($user[0]->manager[0], 'CN=');
                            $name = explode(',OU', $name);
                            $name = str_replace("\,", ',', $name);
                            $managerOfProjektTim = User::where(['name' => $name[0]])->first();
                            if ($managerOfProjektTim != null) {
                                $accessProjektTim[] = $managerOfProjektTim->objectguid;

                            }
                        }
                    }
                    }

                }
                if (!empty($accessProjektTim)) {
                    if (in_array($id_user, $accessProjektTim)) {
                        $accessProjektTim = 1;
                    }
                }
            }

            $supervisor = Organizacia_projektu::where(['id_pp' => $id_projekt, 'id_projektovy_garant' => $id_user])->first();
            $projektVedenie = Projektovy_manazer_pp::where(['id_pp' => $id_projekt, 'id_user' => $id_user])->get();
            if (count($projektVedenie) < 1) {
                $projektVedenie = null;
            }

            $projektTim = Projektovy_tim::where(['id_pp' => $id_projekt, 'id_user' => $id_user])->get();


            if (count($projektTim) < 1) {
                $projektTim = null;
            }

            $riadiaceGremium = Riadiace_gremium::where(['id_pp' => $id_projekt, 'id_user' => $id_user])->get();
            if (count($riadiaceGremium) < 1) {
                $riadiaceGremium = null;
            }

            $projektZadavatelId = Organizacia_projektu::where(['id_pp' => $id_projekt])->value('id_zadavatel_projektu');
            if ($projektZadavatelId != null) {
                $managerCheck = Managers::where(['id_group' => $projektZadavatelId])->value('id_user');
                if ($managerCheck != null) {

                    if ($managerCheck == $id_user) {
                        $userRoleRights->name = "Supervízia projektov";
                        $userRoleRights->slug = "supervisor";
                        return $userRoleRights;
                    }
                }
            }

            if ($supervisor != null) {
                $userRoleRights->name = "Supervízia projektov";
                $userRoleRights->slug = "supervisor";
                return $userRoleRights;
            } elseif ($supervisor == null && $projektVedenie != null) {
                $userRoleRights->name = "Projektové vedenie";
                $userRoleRights->slug = "projekt_vedenie";
                return $userRoleRights;
            } elseif ($supervisor == null && $projektVedenie == null && ($projektTim != null or $riadiaceGremium != null or $accessProjektTim == 1)) {
                $userRoleRights->name = "Projektový tím";
                $userRoleRights->slug = "projekt_tim";
                return $userRoleRights;
            } else {
                $userRoleRights->name = "Everyone";
                $userRoleRights->slug = "everyone";
                return $userRoleRights;
            }
        }
    }
}

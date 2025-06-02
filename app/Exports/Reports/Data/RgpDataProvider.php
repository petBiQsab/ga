<?php

namespace App\Exports\Reports\Data;

use App\Models\Aktivity_pp;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_zamer_roky;
use App\Models\Users_group;
use Carbon\Carbon;

class RgpDataProvider
{
    public function getProjektById($id)
    {
        return Projektove_portfolio::where(['id' => $id])->first();
    }



    public function getZaciatokProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details->datum_zacatia_projektu)) {
            $zaciatok_projektu = Carbon::createFromDate($projekt->PP_PP_Details->datum_zacatia_projektu)->locale('sk_SK');
            return $zaciatok_projektu->monthName . " " . $zaciatok_projektu->year;
        } else return null;
    }

    public function getKoniecProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details->datum_konca_projektu)) {
            $koniec_projektu = Carbon::createFromDate($projekt->PP_PP_Details->datum_konca_projektu)->locale('sk_SK');
            return $koniec_projektu->monthName . " " . $koniec_projektu->year;
        } else return null;
    }

    public function getCielProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->ciel_projektu;
        }
        return null;
    }

    public function getStavProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Stav_projektu))
            {
                return $projekt->PP_PP_Details->PP_Details_Stav_projektu->value;
            }
        }
        return null;
    }

    public function getFazaProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Faza_projektu))
            {
                return $projekt->PP_PP_Details->PP_Details_Faza_projektu->value;
            }
        }
        return null;
    }

    public function getTypProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_TypProjektu) && count($projekt->PP_TypProjektu) > 0) {
            $typ_projektu = [];
            foreach ($projekt->PP_TypProjektu as $typ_projektu_item) {

                $typ_projektu[] = $typ_projektu_item->TypProjektuPP_TypProjektu->value;
            }

            $typ_projektu=implode('/', $typ_projektu);
            return $typ_projektu;
        } else {
            return null;
        }
    }

    private function getSkratkaOddeleniaUser($id_user)
    {
        $user_groups=Users_group::where(['user_id' => $id_user])->whereNotNull('group')->first();
        if ($user_groups!=null) {
            if (isset($user_groups->UsersGroup_Group)) {
                return $user_groups->UsersGroup_Group->skratka;
            }
        }
        return null;
    }

    public function getProjektTim(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyTim) && count($projekt->PP_ProjektovyTim) > 0) {
            $projekt_tim=[];
            foreach ($projekt->PP_ProjektovyTim as $projekt_tim_item) {
                if (!isset($projekt_tim_item->ProjektovyTim_User)) {
                    continue;
                }
                $member=new \stdClass();
                $member->sn=$projekt_tim_item->ProjektovyTim_User->sn;
                $member->givenName= $projekt_tim_item->ProjektovyTim_User->givenName;
                $member->ou=$this->getSkratkaOddeleniaUser($projekt_tim_item->id_user);
                $projekt_tim[]=$member;
            }
            return $projekt_tim;
        }
        return [];
    }

    public function getRiadiaceGremium(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_RiadiaceGremium) && count($projekt->PP_RiadiaceGremium)>0) {
            $riadiace_gremium = [];
            foreach ($projekt->PP_RiadiaceGremium as $projekt_gremium_item) {
                if (!isset($projekt_gremium_item->RiadiaceGremium_User)) {
                    continue;
                }
                $member = new \stdClass();
                $member->sn = $projekt_gremium_item->RiadiaceGremium_User->sn;
                $member->givenName = $projekt_gremium_item->RiadiaceGremium_User->givenName;
                $member->ou = $this->getSkratkaOddeleniaUser($projekt_gremium_item->id_user);
                $riadiace_gremium[] = $member;
            }
            return $riadiace_gremium;
        }
        return [];
    }

    public function getProjektovyManager(Projektove_portfolio $projekt)
    {
        if (count($projekt->PP_ProjektovyManager)>0)
        {
            $projektovy_manager = [];
            foreach ($projekt->PP_ProjektovyManager as $projekt_manager_item) {
                if (!isset($projekt_manager_item->ProjektovyManagerPP_User)) {
                    continue;
                }
                $member = new \stdClass();
                $member->sn = $projekt_manager_item->ProjektovyManagerPP_User->sn;
                $member->givenName = $projekt_manager_item->ProjektovyManagerPP_User->givenName;
                $member->ou = $this->getSkratkaOddeleniaUser($projekt_manager_item->id_user);
                $projektovy_manager[] = $member;
            }

            //array managerov spojí do stringu, oddelí ich pomocou / a pred oddelenie pridá čiarku,
            //ak existuje skratka oddelenia

            $result = implode('/', array_map(function ($member) {
                $userInfo = "{$member->sn} {$member->givenName}";

                if (!empty($member->ou) || $member->ou !== null) {
                    $userInfo .= ", {$member->ou}";
                }

                return $userInfo;
            }, $projektovy_manager));

            return $result;
        }
        return null;
    }

    public function getProjektovyManagerEmail(Projektove_portfolio $projekt)
    {
        if (count($projekt->PP_ProjektovyManager)>0)
        {
            $projektovy_manager_email = [];
            foreach ($projekt->PP_ProjektovyManager as $projekt_manager_item) {
                $projektovy_manager_email[] = $projekt_manager_item->ProjektovyManagerPP_User->email;
            }

            $projektovy_manager_email=implode('/', $projektovy_manager_email);


            return $projektovy_manager_email;
        }
        return null;
    }

    public function getZrealizovaneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details) && !empty($projekt->PP_PP_Details->zrealizovane_aktivity)) {
            return explode(PHP_EOL,$projekt->PP_PP_Details->zrealizovane_aktivity);
        }
        return [];
    }

    public function getPlanovaneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details) && !empty($projekt->PP_PP_Details->planovane_aktivity_na_najblizsi_tyzden)) {
            return explode(PHP_EOL,$projekt->PP_PP_Details->planovane_aktivity_na_najblizsi_tyzden);
        }
        return [];
    }

    public function getRizikaProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details) && !empty($projekt->PP_PP_Details->rizika_projektu)) {
            return explode(PHP_EOL,$projekt->PP_PP_Details->rizika_projektu);
        }
        return [];
    }

    public function getKomentarMTL(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_MTL) && !empty($projekt->PP_MTL->komentar)) {
            return explode(PHP_EOL,$projekt->PP_MTL->komentar);
        }
        return [];
    }

    public function getKategoriaProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details->PP_Details_Kategoria)) {
            return $projekt->PP_PP_Details->PP_Details_Kategoria->value;
        }
        return null;
    }

    public function getMTL(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_MTL))
        {
            return $projekt->PP_MTL->status;
        }

        return null;
    }

    public function getATL(Projektove_portfolio $projekt)
    {
        $results = Aktivity_pp::where('id_pp', $projekt->id)
            ->where(function ($query) {
                $query->whereNull('zaciatok_aktivity')
                    ->orWhereNull('skutocny_zaciatok_aktivity')
                    ->orWhereNull('koniec_aktivity')
                    ->orWhereNull('skutocny_koniec_aktivity');
            })
            ->get();

        if ($results!=null and (count($results)>0))
        {
            $max_diff='';

            foreach ($results as $result_item)
            {
                if ($result_item->zaciatok_aktivity!=null)
                {
                    $zaciatok_aktivity=Carbon::parse($result_item->zaciatok_aktivity)->floorMonth();

                    if ($result_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $skutocny_zaciatok_aktivity=Carbon::parse($result_item->skutocny_zaciatok_aktivity)->floorMonth();
                    }else
                    {
                        $skutocny_zaciatok_aktivity=Carbon::now()->floorMonth();
                    }

                    $monthDiff=$skutocny_zaciatok_aktivity->diffInMonths($zaciatok_aktivity);

                    if (($skutocny_zaciatok_aktivity->gt($zaciatok_aktivity))==false)
                    {
                        $monthDiff=$monthDiff*-1;
                    }

                    if ($monthDiff>$max_diff)
                    {
                        $max_diff=$monthDiff;
                    }
                }
                if ($result_item->koniec_aktivity!=null && $result_item->skutocny_koniec_aktivity==null)
                {
                    $koniec_aktivity=Carbon::parse($result_item->koniec_aktivity)->floorMonth();
                    $skutocny_koniec_aktivity=Carbon::now()->floorMonth();

                    $monthDiff=$skutocny_koniec_aktivity->diffInMonths($koniec_aktivity);

                    if (($skutocny_koniec_aktivity->gt($koniec_aktivity))==false)
                    {
                        $monthDiff=$monthDiff*-1;
                    }

                    if ($monthDiff>$max_diff)
                    {
                        $max_diff=$monthDiff;
                    }
                }
                elseif ($result_item->koniec_aktivity!=null && $result_item->skutocny_koniec_aktivity!=null)
                {
                    $max_diff=0;
                }
            }
            $atl=null;
            if ($max_diff!='')
            {
                if ($max_diff<=0)
                {
                    $atl="green";
                }elseif($max_diff<=2 && $max_diff>=1)
                {
                    $atl="orange";
                }
                elseif($max_diff>2)
                {
                    $atl= "red";
                }
                else $atl=null;
            }
            else $atl=null;
        }
        else
        {
            $atl=null;
        }
        return $atl;
    }

    public function getFinancovanie(Projektove_portfolio $projekt)
    {
        $result = Projektovy_zamer_roky::where('id_pp', $projekt->id)
            ->where(function ($query) {
                $query->where('typ', 'BV')
                    ->orWhere('typ', 'KV');
            })
            ->groupBy('rok')
            ->selectRaw('rok, SUM(value) as value')
            ->get();



        if ($result!=null)
        {
            return $result;
        }
        return [];
    }

    public function gant(Projektove_portfolio $projekt)
    {

        //samotna logika ganta
        if (isset($projekt->PP_AktivityPP_vsetky) && count($projekt->PP_AktivityPP_vsetky)>0)
        {
            $aktivity_gant=new \stdClass();
            $aktivity_gant->count=count($projekt->PP_AktivityPP_vsetky);

            $start_date_border=Carbon::parse("2022-07-01");
            $today=Carbon::now();
            $today->day=1;

            $current_month=$today->diffInMonths($start_date_border);
            $aktivity_gant->current_month_line=$current_month;//pocet plus 1


            foreach ($projekt->PP_AktivityPP_vsetky->sortBy('zaciatok_aktivity') as $aktivity_item)
            {
                $aktivita=new \stdClass();


                //case1
                if ($aktivity_item->zaciatok_aktivity<"2022-07-31" &&
                    ($aktivity_item->koniec_aktivity<="2031-01-01" && $aktivity_item->koniec_aktivity>="2022-07-31"))
                {
                    //dd('case1');

                    $start_date_border=Carbon::parse("2022-07-01");
                    $start_date=Carbon::parse($aktivity_item->zaciatok_aktivity);
                    $start_date->day=1;

                    $end_date=Carbon::parse($aktivity_item->koniec_aktivity);
                    $end_date->day=1;

                    $aktivita->partOne=0;

                    $aktivita->partTwo=$start_date_border->diffInMonths($end_date)+1;

                    $aktivita->partThree=102-$aktivita->partOne-$aktivita->partTwo;

                    $aktivita->zaciatok_aktivity=$aktivity_item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$aktivity_item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$aktivity_item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$aktivity_item->skutocny_koniec_aktivity;

                    if (isset($aktivity_item->AktivityPP_Aktivity))
                    {
                        $aktivita->name=$aktivity_item->AktivityPP_Aktivity->name;
                    }elseif ($aktivity_item->vlastna_aktivita!=null)
                    {
                        $aktivita->name=$aktivity_item->vlastna_aktivita;
                    }


                    if ($aktivity_item->skutocny_koniec_aktivity!=null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="green_cell";
                    }elseif ($aktivity_item->skutocny_koniec_aktivity==null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="orange_cell";
                    }elseif ($aktivity_item->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->color="red_cell";
                    }
                }

                //case2
                elseif(($aktivity_item->zaciatok_aktivity>="2022-07-01" && $aktivity_item->zaciatok_aktivity<"2031-01-01") &&
                    ($aktivity_item->koniec_aktivity<"2031-01-01" && $aktivity_item->koniec_aktivity>="2022-07-31"))
                {

                    $start_date_border=Carbon::parse("2022-07-01");
                    $start_date=Carbon::parse($aktivity_item->zaciatok_aktivity);
                    $start_date->day=1;

                    $end_date_border=Carbon::parse("2031-01-01");
                    $end_date=Carbon::parse($aktivity_item->koniec_aktivity);
                    $end_date->day=1;

                    $aktivita->partOne=$start_date_border->diffInMonths($start_date);
                    $aktivita->partThree=$end_date_border->diffInMonths($end_date)-1;
                    $aktivita->partTwo=102-$aktivita->partOne-$aktivita->partThree;

                    $aktivita->zaciatok_aktivity=$aktivity_item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$aktivity_item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$aktivity_item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$aktivity_item->skutocny_koniec_aktivity;

                    if (isset($aktivity_item->AktivityPP_Aktivity))
                    {
                        $aktivita->name=$aktivity_item->AktivityPP_Aktivity->name;
                    }elseif ($aktivity_item->vlastna_aktivita!=null)
                    {
                        $aktivita->name=$aktivity_item->vlastna_aktivita;
                    }

                    if ($aktivity_item->skutocny_koniec_aktivity!=null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="green_cell";
                    }elseif ($aktivity_item->skutocny_koniec_aktivity==null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="orange_cell";
                    }elseif ($aktivity_item->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->color="red_cell";
                    }
                }

                //case3
                elseif (($aktivity_item->zaciatok_aktivity>="2022-07-01" &&
                        $aktivity_item->zaciatok_aktivity<"2031-01-01") &&
                    ($aktivity_item->koniec_aktivity>="2031-01-01"))
                {

                    $start_date_border=Carbon::parse("2022-07-01");
                    $start_date=Carbon::parse($aktivity_item->zaciatok_aktivity);
                    $start_date->day=1;

                    $end_date=Carbon::parse($aktivity_item->koniec_aktivity);
                    $end_date->day=1;

                    $aktivita->partOne=$start_date->diffInMonths($start_date_border);
                    $aktivita->partTwo=102-$aktivita->partOne;

                    $aktivita->partThree=0;

                    $aktivita->zaciatok_aktivity=$aktivity_item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$aktivity_item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$aktivity_item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$aktivity_item->skutocny_koniec_aktivity;

                    if (isset($aktivity_item->AktivityPP_Aktivity))
                    {
                        $aktivita->name=$aktivity_item->AktivityPP_Aktivity->name;
                    }elseif ($aktivity_item->vlastna_aktivita!=null)
                    {
                        $aktivita->name=$aktivity_item->vlastna_aktivita;
                    }

                    if ($aktivity_item->skutocny_koniec_aktivity!=null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="green_cell";
                    }elseif ($aktivity_item->skutocny_koniec_aktivity==null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="orange_cell";
                    }elseif ($aktivity_item->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->color="red_cell";
                    }

                }

                //case4
                elseif (($aktivity_item->zaciatok_aktivity<"2022-07-01") &&
                    ($aktivity_item->koniec_aktivity>="2031-01-01"))
                {
                    // dd('case4');
                    // dd($aktivity_item);

                    $aktivita->partOne=0;
                    $aktivita->partTwo=102;
                    $aktivita->partThree=0;

                    $aktivita->zaciatok_aktivity=$aktivity_item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$aktivity_item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$aktivity_item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$aktivity_item->skutocny_koniec_aktivity;

                    if (isset($aktivity_item->AktivityPP_Aktivity))
                    {
                        $aktivita->name=$aktivity_item->AktivityPP_Aktivity->name;
                    }elseif ($aktivity_item->vlastna_aktivita!=null)
                    {
                        $aktivita->name=$aktivity_item->vlastna_aktivita;
                    }

                    if ($aktivity_item->skutocny_koniec_aktivity!=null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="green_cell";
                    }elseif ($aktivity_item->skutocny_koniec_aktivity==null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="orange_cell";
                    }elseif ($aktivity_item->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->color="red_cell";
                    }
                }
                //case 5
                elseif (($aktivity_item->zaciatok_aktivity<"2022-07-01") &&
                    ($aktivity_item->koniec_aktivity<"2022-07-01"))
                {
                    // dd('case4');
                    // dd($aktivity_item);

                    $aktivita->partOne=102;
                    $aktivita->partTwo=0;
                    $aktivita->partThree=0;

                    $aktivita->zaciatok_aktivity=$aktivity_item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$aktivity_item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$aktivity_item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$aktivity_item->skutocny_koniec_aktivity;


                    if ($aktivity_item->skutocny_koniec_aktivity!=null)
                    {
                        $end_date=Carbon::parse($aktivity_item->koniec_aktivity);

                        $aktivita->finished=1;
                        $aktivita->date=$end_date->month.".".$end_date->year;
                    }

                    if (isset($aktivity_item->AktivityPP_Aktivity))
                    {
                        $aktivita->name=$aktivity_item->AktivityPP_Aktivity->name;
                    }elseif ($aktivity_item->vlastna_aktivita!=null)
                    {
                        $aktivita->name=$aktivity_item->vlastna_aktivita;
                    }

                    if ($aktivity_item->skutocny_koniec_aktivity!=null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="green_cell";
                    }elseif ($aktivity_item->skutocny_koniec_aktivity==null and $aktivity_item->skutocny_zaciatok_aktivity!=null)
                    {
                        $aktivita->color="orange_cell";
                    }elseif ($aktivity_item->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->color="red_cell";
                    }
                }

                else
                {
                    continue;
                }

                $aktivity_gant->items[]=$aktivita;
                if (count($aktivity_gant->items)>12)
                {
                    $aktivity_gant->page[]=$aktivity_gant->items;
                    $aktivity_gant->items=null;
                }
            }
            if (isset($aktivity_gant->items))
            {
                if (count($aktivity_gant->items)>0)
                {
                    $aktivity_gant->page[]=$aktivity_gant->items;
                    $aktivity_gant->items=null;
                }
            }

            return $aktivity_gant;
        }
        else
        {
            $aktivity_gant=null;
        }
    }
}

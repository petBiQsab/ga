<?php

namespace App\Http\Repositories;

use App\Http\Interface\DataInterface;
use App\Http\Rights\ProjectUserRights;
use App\Models\Aktivita_Kategoria;
use App\Models\Aktivity;
use App\Models\Aktivity_pp;
use App\Models\Groups;
use App\Models\Managers;
use App\Models\MTL_log;
use App\Models\Projektove_portfolio;
use App\Models\TestingUsers;
use App\Models\User;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use stdClass;
use function Symfony\Component\String\s;
use function Symfony\Component\Translation\t;

class DataRepository implements DataInterface
{
    public function getCielProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->ciel_projektu;
        }
        else return null;
    }

    public function getZakladneInformacie(Projektove_portfolio $projekt, $dataset)
    {
        $zakladne_informacie=new \stdClass();
        $zakladne_informacie->id_pp=$projekt->id_projekt;
        $zakladne_informacie->id_original=$projekt->id_original;
        $zakladne_informacie->id_parent=$projekt->id_parent;
        $zakladne_informacie->id_child=$projekt->id_child;
        $zakladne_informacie->nazov_projektu=$projekt->nazov_projektu;
        $zakladne_informacie->updated_at=$projekt->updated_at;
        $zakladne_informacie->alt_nazov_projektu=$projekt->alt_nazov_projektu;
        $zakladne_informacie->ciel_projektu=$this->getCielProjektu($projekt);

        $zakladne_informacie->updated_by=$projekt->updated_by;
        $user = User::where('objectguid', $projekt->updated_by)->first();
        $zakladne_informacie->updated_by = $user?->name;

        $dataset->zakladne_informacie=$zakladne_informacie;

        return $dataset;
    }

    public function getStrategickyCielPHSR(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PHSR))
        {
            $phsr_data=$projekt->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $phsr_strateg_ciel=[];
                foreach ($phsr_data as $item)
                {
                    if (isset($item->PP_PHSR_Strateg_ciel))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_phsr;
                        $obj->value=$item->PP_PHSR_Strateg_ciel->value;
                        $phsr_strateg_ciel[]=$obj;
                    }
                }
                return $phsr_strateg_ciel;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }
    public function getSpecifickyCielPHSR(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PHSR))
        {
            $phsr_data=$projekt->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $phsr_speci_ciel=[];
                foreach ($phsr_data as $item)
                {
                    if (isset($item->PP_PHSR_Speci_ciel))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_phsr;
                        $obj->value=$item->PP_PHSR_Speci_ciel->value;
                        $phsr_speci_ciel[]=$obj;
                    }
                }
                return $phsr_speci_ciel;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getProgram(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PHSR))
        {
            $phsr_data=$projekt->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $phsr_program=[];
                foreach ($phsr_data as $item)
                {
                    if (isset($item->PP_PHSR_Program))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_phsr;
                        $obj->value=$item->PP_PHSR_Program->value;
                        $phsr_program[]=$obj;
                    }
                }
                return $phsr_program;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getMeratelnyVystupovyUkazovatel(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->meratelny_vystupovy_ukazovatel;
        }
        else return null;
    }

    public function getPrepojenieNaBA30(Projektove_portfolio $projekt, $dataset)
    {
        $phsr=new \stdClass();
        $phsr->strategicky_ciel_PHSR=[];
        $phsr->specificky_ciel_PHSR=[];
        $phsr->program=[];

        $phsr->meratelny_vystupovy_ukazovatel=$this->getMeratelnyVystupovyUkazovatel($projekt);

        $phsr->strategicky_ciel_PHSR=$this->getStrategickyCielPHSR($projekt);
        $phsr->specificky_ciel_PHSR=$this->getSpecifickyCielPHSR($projekt);
        $phsr->program=$this->getProgram($projekt);
        $dataset->prepojenie_na_ba30=$phsr;
    }

    public function getTypProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_TypProjektu))
        {
            $data=$projekt->PP_TypProjektu;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->TypProjektuPP_TypProjektu))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_typ_projektu;
                        $obj->value=$item->TypProjektuPP_TypProjektu->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getKategoria(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Kategoria))
            {
                $output->id=$projekt->PP_PP_Details->id_kategoria_projektu;
                $output->value=$projekt->PP_PP_Details->PP_Details_Kategoria->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getPrioritneOblasti(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PrioritneOblasti))
        {
            $data=$projekt->PP_PrioritneOblasti;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->PrioritneOblastiPP_PrioritneOblasti))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_prioritne_oblasti;
                        $obj->value=$item->PrioritneOblastiPP_PrioritneOblasti->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getRyg(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Ryg))
            {
                $output->id=$projekt->PP_PP_Details->id_ryg;
                $output->value=$projekt->PP_PP_Details->PP_Details_Ryg->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getMuscow(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Muscow))
            {
                $output->id=$projekt->PP_PP_Details->id_muscow;
                $output->value=$projekt->PP_PP_Details->PP_Details_Muscow->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getZaradenieProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $zaradenie_projektu=new \stdClass();

        $zaradenie_projektu->typ_projektu= $this->getTypProjektu($projekt);
        $zaradenie_projektu->kategoria= $this->getKategoria($projekt);
        $zaradenie_projektu->prioritne_oblasti= $this->getPrioritneOblasti($projekt);
        $zaradenie_projektu->ryg = $this->getRyg($projekt);
        $zaradenie_projektu->muscow = $this->getMuscow($projekt);
        $dataset->zaradenie_projektu=$zaradenie_projektu;
    }

    public function getStavProjektu(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Stav_projektu))
            {
                $output->id=$projekt->PP_PP_Details->id_stav_projektu;
                $output->value=$projekt->PP_PP_Details->PP_Details_Stav_projektu->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getFazaProjektu(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_PP_Details))
        {
            if (isset($projekt->PP_PP_Details->PP_Details_Faza_projektu))
            {
                $output->id=$projekt->PP_PP_Details->id_faza_projektu;
                $output->value=$projekt->PP_PP_Details->PP_Details_Faza_projektu->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getZivotnyCyklusProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $zivotny_cyklus_projektu=new \stdClass();

        $zivotny_cyklus_projektu->stav_projektu=$this->getStavProjektu($projekt);
        $zivotny_cyklus_projektu->faza_projektu=$this->getFazaProjektu($projekt);

        $dataset->zivotny_cyklus_projektu=$zivotny_cyklus_projektu;
    }

    public function getDatumZaciatkuProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            $obj=new \stdClass();
            $obj->type='m.Y';
            $obj->value=$projekt->PP_PP_Details->datum_zacatia_projektu;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='m.Y';
            $obj->value=null;
            return $obj;
        }
    }

    public function getDatumKoncaProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            $obj=new \stdClass();
            $obj->type='m.Y';
            $obj->value=$projekt->PP_PP_Details->datum_konca_projektu;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='m.Y';
            $obj->value=null;
            return $obj;
        }
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


            if ($max_diff!='')
            {
                if ($max_diff<=0)
                {
                    return "green";
                }elseif($max_diff<=2 && $max_diff>=1)
                {
                    return "orange";
                }
                elseif($max_diff>2)
                {
                    return "red";
                }
                else return null;
            }
            else return null;

        }
        else
        {
            return null;
        }


        return null;
    }


    public function getTerminyProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $terminy_projektu=new \stdClass();
        $terminy_projektu->atl=$this->getATL($projekt);
        $terminy_projektu->datum_zacatia_projektu=$this->getDatumZaciatkuProjektu($projekt);
        $terminy_projektu->datum_konca_projektu=$this->getDatumKoncaProjektu($projekt);
        $dataset->terminy_projektu=$terminy_projektu;
    }

    public function getZodpovedneOsoby(Aktivity_pp $item)
    {
        if (isset($item->AktivityPP_AktivityZodpovedneOsoby))
        {
            $data=$item->AktivityPP_AktivityZodpovedneOsoby;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    $obj=new \stdClass();
                    if (isset($item->AktivityZodpovedneOsoby_User))
                    {
                        $obj->id=$item->id_user;
                        $obj->value=$item->AktivityZodpovedneOsoby_User->name;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getStandardneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_AktivityPP_standard))
        {
            $data=$projekt->PP_AktivityPP_standard;
            if (count($data)>0)
            {
                $output=[];

                $sortedData = $data->sortBy([
                    ['AktivityPP_Aktivity.id_kategoria', 'asc'],
                    ['zaciatok_aktivity', 'asc'],
                ]);

                foreach ($sortedData as $item)
                {
                    $aktivita= new \stdClass();
                    $aktivita->id_aktivita=$item->id_aktivita;
                    if (isset($item->AktivityPP_Aktivity))
                    {
                        $aktivita->value=$item->AktivityPP_Aktivity->name;
                        $aktivita->headerTitle=$item->AktivityPP_Aktivity->Aktivity_Kategoria->value;
                        $aktivita->flag=$item->AktivityPP_Aktivity->flag;
                        $aktivita->note=$item->AktivityPP_Aktivity->note;
                    }else
                    {
                        continue;
                    }
                    $aktivita->zodpovedni=$this->getZodpovedneOsoby($item);
                    $aktivita->zaciatok_aktivity=$item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$item->skutocny_koniec_aktivity;

                    $output[]=$aktivita;
                }

                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getVlastneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_AktivityPP_vlastne))
        {
            $data=$projekt->PP_AktivityPP_vlastne;
            if (count($data)>0)
            {
                $output=[];
                $data = $data->sortBy([
                    ['id_kategoria', 'asc'],
                    ['zaciatok_aktivity', 'asc'],
                ]);
                foreach ($data as $item)
                {
                    $aktivita= new \stdClass();
                    $aktivita->id_aktivita=null;
                    $aktivita->value=$item->vlastna_aktivita;
                    if (isset($item->AktivityPP_Kategoria))
                    {
                        $kategoria=new \stdClass();
                        $kategoria->id=$item->AktivityPP_Kategoria->id;
                        $kategoria->value=$item->AktivityPP_Kategoria->value;
                        $aktivita->headerTitle=$kategoria;
                    }

                    $aktivita->zodpovedni=$this->getZodpovedneOsoby($item);
                    $aktivita->zaciatok_aktivity=$item->zaciatok_aktivity;
                    $aktivita->skutocny_zaciatok_aktivity=$item->skutocny_zaciatok_aktivity;
                    $aktivita->koniec_aktivity=$item->koniec_aktivity;
                    $aktivita->skutocny_koniec_aktivity=$item->skutocny_koniec_aktivity;

                    $output[]=$aktivita;
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function isReportingON(Projektove_portfolio $projekt)
    {
        $state=$this->getReporting($projekt);
        if ((isset($state->id)) && $state->id==1)
        {
            return 1;
        }else return 0;

    }


    public function getMTL(Projektove_portfolio $projekt)
    {
        if ($this->isReportingON($projekt)==1)
        {
            if (isset($projekt->PP_MTL))
            {
                return $projekt->PP_MTL->status;
            }
            else return null;
        }
        else return null;
    }

    public function getKomentar(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_MTL))
        {
            return $projekt->PP_MTL->komentar;
        }
        else return null;
    }

    public function getRizikaProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->rizika_projektu;
        }
        else return null;
    }

    public function getZrealizovaneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->zrealizovane_aktivity;
        }
        else return null;
    }

    public function getPlanovaneAktivity(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->planovane_aktivity_na_najblizsi_tyzden;
        }
        else return null;
    }


    public function getAktivity(Projektove_portfolio $projekt, $dataset)
    {
        $aktivity=new \stdClass();

        $aktivity->aktivity_standard=$this->getStandardneAktivity($projekt);
        $aktivity->aktivity_vlastne=$this->getVlastneAktivity($projekt);

        $aktivity->mtl=$this->getMTL($projekt);

        $aktivity->komentar=$this->getKomentar($projekt);

        $aktivity->rizika_projektu=$this->getRizikaProjektu($projekt);
        $aktivity->zrealizovane_aktivity=$this->getZrealizovaneAktivity($projekt);
        $aktivity->planovane_aktivity_na_najblizsi_tyzden=$this->getPlanovaneAktivity($projekt);

        $aktivity->rizika_projektu_preview=$this->getRizikaProjektu($projekt);
        $aktivity->zrealizovane_aktivity_preview=$this->getZrealizovaneAktivity($projekt);
        $aktivity->planovane_aktivity_na_najblizsi_tyzden_preview=$this->getPlanovaneAktivity($projekt);

        $dataset->aktivity=$aktivity;

    }

    public function getMagistratnyGarant(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_OrganizaciaProjektu))
        {
            if (isset($projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_MagistratnyGarant))
            {
                $output->id=$projekt->PP_OrganizaciaProjektu->id_magistratny_garant;
                $output->value=$projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_MagistratnyGarant->name;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getPolitickyGarant(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_OrganizaciaProjektu))
        {
            if (isset($projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_PolitickyGarant))
            {
                $output->id=$projekt->PP_OrganizaciaProjektu->id_politicky_garant;
                $output->value=$projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_PolitickyGarant->name;
                return $output;
            }
            else return null;
        }
        else return null;
    }


    public function getZadavatelProjektu(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_OrganizaciaProjektu))
        {
            if (isset($projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_Groups_Zadavatel))
            {
                $output->id=$projekt->PP_OrganizaciaProjektu->id_zadavatel_projektu;
                $output->value=$projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_Groups_Zadavatel->cn;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getProjektovyGarant(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_OrganizaciaProjektu))
        {
            if (isset($projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_Garant))
            {
                $output->id=$projekt->PP_OrganizaciaProjektu->id_projektovy_garant;
                $output->value=$projekt->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_Garant->name;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getUtvarProjektovehoManagera(Projektove_portfolio $projekt)
    {
        return [];
    }

    public function getProjektovyManager(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyManager))
        {
            $data=$projekt->PP_ProjektovyManager;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyManagerPP_User))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_user;
                        $obj->value=$item->ProjektovyManagerPP_User->name;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }

    }

    public function getCoopUtvary(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_CoopUtvary))
        {
            $data=$projekt->PP_CoopUtvary;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->CoopUtvary_Groups))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_group;
                        $obj->value=$item->CoopUtvary_Groups->cn;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getCoopOrganizacie(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_CoopOrganizacie))
        {
            $data=$projekt->PP_CoopOrganizacie;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->CoopOrganizacie_Groups))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_group;
                        $obj->value=$item->CoopOrganizacie_Groups->cn;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getExterniStakeholderi(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_OrganizaciaProjektu))
        {
            return $projekt->PP_OrganizaciaProjektu->externi_stakeholderi;
        }
        else return null;
    }

    public function getSprava(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_Sprava))
        {
            $data=$projekt->PP_Sprava;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->Sprava_Groups))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_group;
                        $obj->value=$item->Sprava_Groups->cn;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getUdrzba(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_Udrzba))
        {
            $data=$projekt->PP_Udrzba;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->Udrzba_Groups))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_group;
                        $obj->value=$item->Udrzba_Groups->cn;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getRiadiaceGremium(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_RiadiaceGremium))
        {
            $data=$projekt->PP_RiadiaceGremium;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->RiadiaceGremium_User))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_user;
                        $obj->value=$item->RiadiaceGremium_User->name;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }

    }

    public function getProjektovyTim(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyTim))
        {
            $data=$projekt->PP_ProjektovyTim;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyTim_User))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_user;
                        $obj->value=$item->ProjektovyTim_User->name;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }


    public function getOrganizaciaProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $organizacia_projektu=new \stdClass();

        $organizacia_projektu->magistratny_garant=$this->getMagistratnyGarant($projekt);
        $organizacia_projektu->politicky_garant=$this->getPolitickyGarant($projekt);
        $organizacia_projektu->zadavatel_projektu=$this->getZadavatelProjektu($projekt);
        $organizacia_projektu->projektovy_garant=$this->getProjektovyGarant($projekt);
        $organizacia_projektu->utvar_projektoveho_managera=$this->getUtvarProjektovehoManagera($projekt);
        $organizacia_projektu->projektovy_manager=$this->getProjektovyManager($projekt);
        $organizacia_projektu->coop_utvary=$this->getCoopUtvary($projekt);
        $organizacia_projektu->coop_organizacie=$this->getCoopOrganizacie($projekt);
        $organizacia_projektu->externi_stakeholderi=$this->getExterniStakeholderi($projekt);
        $organizacia_projektu->sprava=$this->getSprava($projekt);
        $organizacia_projektu->udrzba=$this->getUdrzba($projekt);
        $organizacia_projektu->riadiace_gremium=$this->getRiadiaceGremium($projekt);
        $organizacia_projektu->projektovy_tim=$this->getProjektovyTim($projekt);

        $dataset->organizacia_projektu=$organizacia_projektu;
    }

    public function getDatumSchvaleniaId(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=$projekt->PP_SchvalovanieProjektu->datum_schvalenia_ID;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=null;
            return $obj;
        }
    }

    public function getSchvaleniePIPG(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            if (isset($projekt->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPIPG))
            {
                $output->id=$projekt->PP_SchvalovanieProjektu->id_schvalenie_pi_na_pg;
                $output->value=$projekt->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPIPG->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getHyperlinkPI(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            return $projekt->PP_SchvalovanieProjektu->hyperlink_na_pi;
        }
        else return null;
    }

    public function getPripomienkyPI(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            return $projekt->PP_SchvalovanieProjektu->pripomienky_k_pi;
        }
        else return null;
    }

    public function getSchvaleniePZPG(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            if (isset($projekt->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPZPG))
            {
                $output->id=$projekt->PP_SchvalovanieProjektu->id_schvalenie_pz_na_pg;
                $output->value=$projekt->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPZPG->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getHyperlinkPZ(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            return $projekt->PP_SchvalovanieProjektu->hyperlink_na_pz;
        }
        else return null;
    }

    public function getPripomienkyPZ(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            return $projekt->PP_SchvalovanieProjektu->pripomienky_k_pz;
        }
        else return null;
    }

    public function getDatumSchvaleniaProjektuPPP(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=$projekt->PP_SchvalovanieProjektu->datum_schvalenia_projektu_ppp;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=null;
            return $obj;
        }
    }

    public function getDatumSchvaleniaProjektuMSZ(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=$projekt->PP_SchvalovanieProjektu->datum_schvalenia_projektu_msz;
            return $obj;

        }
        else
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=null;
            return $obj;
        }
    }

    public function getDatumSchvaleniePIPG(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=$projekt->PP_SchvalovanieProjektu->datum_schvalenia_pi_na_pg;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=null;
            return $obj;
        }

    }

    public function getDatumSchvaleniePZPG(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SchvalovanieProjektu))
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=$projekt->PP_SchvalovanieProjektu->datum_schvalenia_pz_na_pg;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='d.m.Y';
            $obj->value=null;
            return $obj;
        }
    }


    public function getSchvalenieProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $schvalenie_projektu=new \stdClass();

        $schvalenie_projektu->datum_schvalenie_id=$this->getDatumSchvaleniaId($projekt);
        $schvalenie_projektu->schvalenie_pi_na_pg=$this->getSchvaleniePIPG($projekt);
        $schvalenie_projektu->datum_schvalenia_pi_na_pg=$this->getDatumSchvaleniePIPG($projekt);
        $schvalenie_projektu->hyperlink_na_pi=$this->getHyperlinkPI($projekt);
        $schvalenie_projektu->pripomienky_k_pi=$this->getPripomienkyPI($projekt);
        $schvalenie_projektu->schvalenie_pz_na_pg=$this->getSchvaleniePZPG($projekt);
        $schvalenie_projektu->datum_schvalenia_pz_na_pg=$this->getDatumSchvaleniePZPG($projekt);
        $schvalenie_projektu->hyperlink_na_pz=$this->getHyperlinkPZ($projekt);
        $schvalenie_projektu->pripomienky_k_pz=$this->getPripomienkyPZ($projekt);
        $schvalenie_projektu->datum_schvalenia_projektu_ppp=$this->getDatumSchvaleniaProjektuPPP($projekt);
        $schvalenie_projektu->datum_schvalenia_projektu_msz=$this->getDatumSchvaleniaProjektuMSZ($projekt);

        $dataset->schvalenie_projektu=$schvalenie_projektu;
    }

    public function getExterneFinancovanie(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            if (isset($projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_ExterneFinancovanie))
            {
                $output->id=$projekt->PP_DoplnujuceUdaje->id_externe_financovanie;
                $output->value=$projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_ExterneFinancovanie->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getZdrojExternehoFinancovania(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            return $projekt->PP_DoplnujuceUdaje->zdroj_externeho_financovania;
        }
        else return null;
    }

    public function getSumaExternehoFinancovania(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_DoplnujuceUdaje->suma_externeho_financovania  ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getPodielExternehoFinancovania(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_DoplnujuceUdaje->podiel_externeho_financovania_z_celkovej_ceny  ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getMestskaCast(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_MestskaCastPP))
        {
            $data=$projekt->PP_MestskaCastPP;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->MestkaCastPP_MestskaCast))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_mc;
                        $obj->value=$item->MestkaCastPP_MestskaCast->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getPriorita(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            if (isset($projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_Priorita))
            {
                $output->id=$projekt->PP_DoplnujuceUdaje->id_priorita;
                $output->value=$projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_Priorita->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getPrioritaNew(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            if (isset($projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_PrioritaNew))
            {
                $output->id=$projekt->PP_DoplnujuceUdaje->id_priorita_new;
                $output->value=$projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_PrioritaNew->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getVerejnaPraca(Projektove_portfolio $projekt)
    {
        $output=new \stdClass();

        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            if (isset($projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_VerejnaPraca))
            {
                $output->id=$projekt->PP_DoplnujuceUdaje->id_verejna_praca;
                $output->value=$projekt->PP_DoplnujuceUdaje->Doplnujuce_udaje_VerejnaPraca->value;
                return $output;
            }
            else return null;
        }
        else return null;
    }

    public function getSuvisiaceProjekty(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SuvisiaceProjekty))
        {
            $data=$projekt->PP_SuvisiaceProjekty;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->SuvisiaceProjekty_PP))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_suvis_projekt;
                        $obj->value=$item->SuvisiaceProjekty_PP->id_projekt." - ".$item->SuvisiaceProjekty_PP->nazov_projektu;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getHashtag(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_HashtagPP))
        {
            $data=$projekt->PP_HashtagPP;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->HashtagPP_Hashtag))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_hashtag;
                        $obj->value=$item->HashtagPP_Hashtag->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getSpecifickeAtributy(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_SpeciAtributPP))
        {
            $data=$projekt->PP_SpeciAtributPP;
            if (count($data)>0)
            {
                $output=[];
                foreach ($data as $item)
                {
                    if (isset($item->SpeciAtributPP_SpeciAtribut))
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id_speci_atribut;
                        $obj->value=$item->SpeciAtributPP_SpeciAtribut->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getHyperlinkUloziskoProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_DoplnujuceUdaje))
        {
            return $projekt->PP_DoplnujuceUdaje->hyperlink_na_ulozisko_projektu;
        }
        else return null;
    }

    public function getDoplnujuceUdaje(Projektove_portfolio $projekt, $dataset)
    {
        $doplnujuce_udaje=new \stdClass();

        $doplnujuce_udaje->externe_financovanie=$this->getExterneFinancovanie($projekt);
        $doplnujuce_udaje->zdroj_externeho_financovania=$this->getZdrojExternehoFinancovania($projekt);
        $doplnujuce_udaje->suma_externeho_financovania=$this->getSumaExternehoFinancovania($projekt);
        $doplnujuce_udaje->podiel_externeho_financovania_z_celkovej_ceny=$this->getPodielExternehoFinancovania($projekt);
        $doplnujuce_udaje->mestska_cast=$this->getMestskaCast($projekt);
        $doplnujuce_udaje->id_priorita=$this->getPriorita($projekt);
        $doplnujuce_udaje->id_priorita_new=$this->getPrioritaNew($projekt);
        $doplnujuce_udaje->verejna_praca=$this->getVerejnaPraca($projekt);
        $doplnujuce_udaje->suvisiace_projekty=$this->getSuvisiaceProjekty($projekt);
        $doplnujuce_udaje->hashtag=$this->getHashtag($projekt);
        $doplnujuce_udaje->specificke_atributy=$this->getSpecifickeAtributy($projekt);
        $doplnujuce_udaje->hyperlink_na_ulozisko_projektu=$this->getHyperlinkUloziskoProjektu($projekt);
        $dataset->doplnujuce_udaje=$doplnujuce_udaje;

    }

    public function getNajAktualnejsiaCenaProjektuDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_PP_Details->najaktualnejsia_cena_projektu_vrat_DPH  ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getNajAktualnejsieRocnePrevadzkoveNakladyProjektuDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_PP_Details->najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH  ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getCelkoveVydavkyProjektu(Projektove_portfolio $projekt, $dataset)
    {
        $celkove_vydavky_projektu=new \stdClass();
        $celkove_vydavky_projektu->najaktualnejsia_cena_projektu_vrat_DPH=$this->getNajAktualnejsiaCenaProjektuDPH($projekt);
        $celkove_vydavky_projektu->najaktual_rocne_prevadzkove_naklady_projektu_vrat_DPH=$this->getNajAktualnejsieRocnePrevadzkoveNakladyProjektuDPH($projekt);
        $dataset->celkove_vydavky_projektu=$celkove_vydavky_projektu;
    }

    public function getCelkomBVaKVvratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovaIdea))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_ProjektovaIdea->celkom_bv_a_kv_vrat_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getRocnePrevadzkoveNakladyProjektVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovaIdea))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_ProjektovaIdea->rocne_prevadzkove_naklady_projektu_vrat_dph  ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getIdeaBezneOcakavaneRocneNakladyProjektuDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovaIdea))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_ProjektovaIdea->idea_bezne_ocakavane_rocne_naklady_projektu_s_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getIdeaKapitaloveOcakRocneNakladyProejtkuDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovaIdea))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_ProjektovaIdea->idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    private function generateDefaultFinancovanieRoky($year_from,$year_to)
    {
        $output=[];
        for ($i=$year_from;$i<=$year_to;$i++)
        {
            $obj=new \stdClass();
            $obj->id=null;
            $obj->rok=$i;
            $obj->type='number';
            $obj->value=0;
            $output[]=$obj;
        }
        return $output;
    }
    public function getProjektovaIdeaRokyBV(Projektove_portfolio $projekt)
    {

        if ($projekt->id===null)
        {
           return $this->generateDefaultFinancovanieRoky(2021,2030,);
        }

        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovaIdeaRokyBV))
            {
                $output=[];
                if (count($projekt->PP_ProjektovaIdeaRokyBV)>0)
                {
                    foreach ($projekt->PP_ProjektovaIdeaRokyBV as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }


    public function getProjektovaIdeaRokyKV(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }
        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovaIdeaRokyKV))
            {
                $output=[];

                if (count($projekt->PP_ProjektovaIdeaRokyKV)>0)
                {
                    foreach ($projekt->PP_ProjektovaIdeaRokyKV as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getProjektovaIdea(Projektove_portfolio $projekt, $dataset)
    {
        $projektova_idea=new \stdClass();
        $projektova_idea->celkom_bv_a_kv_vrat_dph=$this->getCelkomBVaKVvratDPH($projekt);
        $projektova_idea->rocne_prevadzkove_naklady_projektu_vrat_dph=$this->getRocnePrevadzkoveNakladyProjektVratDPH($projekt);
        $projektova_idea->idea_bezne_ocakavane_rocne_naklady_projektu_s_dph=$this->getIdeaBezneOcakavaneRocneNakladyProjektuDPH($projekt);
        $projektova_idea->idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph=$this->getIdeaKapitaloveOcakRocneNakladyProejtkuDPH($projekt);

        $projektova_idea_roky=new \stdClass();
        $projektova_idea_roky->bv=$this->getProjektovaIdeaRokyBV($projekt);
        $projektova_idea_roky->kv=$this->getProjektovaIdeaRokyKV($projekt);
        $projektova_idea->projektova_idea_roky=$projektova_idea_roky;
        $dataset->projektova_idea=$projektova_idea;
    }

    public function getCelkomVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=$projekt->PP_ProjektovyZamer->celkom_vrat_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }

    }

    public function getRocnePrevadzkoveNakladyVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_ProjektovyZamer->rocne_prevadzkove_naklady_vrat_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getZamerBezneAktulOcakavaneRocneNakladProjektSDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_ProjektovyZamer->zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getZamerKapitalAktulOcakavaneRocneNakladProjektSDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_ProjektovyZamer->zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph ?? 0;
            return $obj;

        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getBeznePrijmyCelkomVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_ProjektovyZamer->bezne_prijmy_celkom_vrat_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getKapitalPrijmyCelkomVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_ProjektovyZamer))
        {

            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_ProjektovyZamer->kapitalove_prijmy_celkom_vrat_dph ?? 0 ;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getProjektovyZamerRokyBV(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }
        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovyZamerRokyBV))
            {
                $output=[];

                if (count($projekt->PP_ProjektovyZamerRokyBV)>0)
                {
                    foreach ($projekt->PP_ProjektovyZamerRokyBV as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getProjektovyZamerRokyKV(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }
        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovyZamerRokyKV))
            {
                $output=[];

                if (count($projekt->PP_ProjektovyZamerRokyKV)>0)
                {
                    foreach ($projekt->PP_ProjektovyZamerRokyKV as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getProjektovyZamerRokyBP(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }
        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovyZamerRokyBP))
            {
                $output=[];

                if (count($projekt->PP_ProjektovyZamerRokyBP)>0)
                {
                    foreach ($projekt->PP_ProjektovyZamerRokyBP as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getProjektovyZamerRokyKP(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }
        if (isset($projekt))
        {
            if(isset($projekt->PP_ProjektovyZamerRokyKP))
            {
                $output=[];

                if (count($projekt->PP_ProjektovyZamerRokyKP)>0)
                {
                    foreach ($projekt->PP_ProjektovyZamerRokyKP as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }


    public function getProjektovyZamer(Projektove_portfolio $projekt, $dataset)
    {
        $projektovy_zamer=new \stdClass();
        $projektovy_zamer->celkom_vrat_dph=$this->getCelkomVratDPH($projekt);
        $projektovy_zamer->rocne_prevadzkove_naklady_vrat_dph=$this->getRocnePrevadzkoveNakladyVratDPH($projekt);
        $projektovy_zamer->zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph=$this->getZamerBezneAktulOcakavaneRocneNakladProjektSDPH($projekt);
        $projektovy_zamer->zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph=$this->getZamerKapitalAktulOcakavaneRocneNakladProjektSDPH($projekt);
        $projektovy_zamer->bezne_prijmy_celkom_vrat_dph=$this->getBeznePrijmyCelkomVratDPH($projekt);
        $projektovy_zamer->kapitalove_prijmy_celkom_vrat_dph=$this->getKapitalPrijmyCelkomVratDPH($projekt);

        $projektovy_zamer_roky=new \stdClass();
        $projektovy_zamer_roky->bv=$this->getProjektovyZamerRokyBV($projekt);
        $projektovy_zamer_roky->kv=$this->getProjektovyZamerRokyKV($projekt);
        $projektovy_zamer_roky->bp=$this->getProjektovyZamerRokyBP($projekt);
        $projektovy_zamer_roky->kp=$this->getProjektovyZamerRokyKP($projekt);

        $projektovy_zamer->projektovy_zamer_roky=$projektovy_zamer_roky;
        $dataset->projektovy_zamer=$projektovy_zamer;
    }

    public function getKvalifikovanyOdhadCenyProjektu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_KvalifikovanyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_KvalifikovanyZamer->kvalifikovany_odhad_ceny_projektu ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getKvalifikovanyOdhadRocnychPrevadzkovychNakladovVratDPH(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_KvalifikovanyZamer))
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value= $projekt->PP_KvalifikovanyZamer->kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph ?? 0;
            return $obj;
        }
        else
        {
            $obj=new \stdClass();
            $obj->type='number';
            $obj->value=0;
            return $obj;
        }
    }

    public function getZdrojInfoKvalifOdhad(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_KvalifikovanyZamer))
        {
            return $projekt->PP_KvalifikovanyZamer->zdroj_info_kvalif_odhad;

        }
        else return null;
    }

    public function getKvalifikovanyOdhadRoky(Projektove_portfolio $projekt)
    {
        if ($projekt->id===null)
        {
            return $this->generateDefaultFinancovanieRoky(2021,2030);
        }

        if (isset($projekt))
        {
            if(isset($projekt->PP_KvalifikovanyOdhadRoky))
            {
                $output=[];
                if (count($projekt->PP_KvalifikovanyOdhadRoky)>0)
                {
                    foreach ($projekt->PP_KvalifikovanyOdhadRoky as $item)
                    {
                        $obj=new \stdClass();
                        $obj->id=$item->id;
                        $obj->rok=$item->rok;
                        $obj->type='number';
                        $obj->value=$item->value ?? 0;
                        $output[]=$obj;
                    }
                }
                return $output;
            }else
            {
                return [];
            }
        }else
        {
            return [];
        }
    }

    public function getKvalifikovanyOdhad(Projektove_portfolio $projekt, $dataset)
    {
        $kvalifikovany_odhad=new \stdClass();
        $kvalifikovany_odhad->kvalifikovany_odhad_ceny_projektu=$this->getKvalifikovanyOdhadCenyProjektu($projekt);
        $kvalifikovany_odhad->kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph=$this->getKvalifikovanyOdhadRocnychPrevadzkovychNakladovVratDPH($projekt);
        $kvalifikovany_odhad->zdroj_info_kvalif_odhad=$this->getZdrojInfoKvalifOdhad($projekt);

        $kvalifikovany_odhad_roky=new \stdClass();
        $kvalifikovany_odhad_roky->roky=$this->getKvalifikovanyOdhadRoky($projekt);
        $kvalifikovany_odhad->kvalifikovany_odhad_roky=$kvalifikovany_odhad_roky;
        $dataset->kvalifikovany_odhad=$kvalifikovany_odhad;
    }

    public function getReporting(Projektove_portfolio $projekt)
    {

        if (isset($projekt->PP_Reporting))
        {
            $output=new \stdClass();
            $output->id=$projekt->id_reporting;
            $output->value=$projekt->PP_Reporting->value;
            return $output;
        }
        else return null;
    }

    public function getPlanovanieRozpoctu(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_Planovanie_rozpoctu))
        {
            $output=new \stdClass();
            $output->id=$projekt->id_planovanie_rozpoctu;
            $output->value=$projekt->PP_Planovanie_rozpoctu->value;
            return $output;
        }
        else return null;
    }

    public function getMaxRok(Projektove_portfolio $projekt)
    {
        $obj=new \stdClass();
        $obj->type='number';
        $obj->value= $projekt->max_rok;
        return $obj;
    }

    public function getPoznamky(Projektove_portfolio $projekt)
    {
        if (isset($projekt->PP_PP_Details))
        {
            return $projekt->PP_PP_Details->poznamky;
        }
        else return null;
    }

    public function getRGPready(Projektove_portfolio $projekt)
    {
        if($projekt->rgp_ready!=null)
        {
            $obj=new \stdClass();
            $obj->type='timestamp';
            $obj->value= $projekt->rgp_ready;
            return $obj;
        }
        return null;
    }

    public function getMTL_Log(Projektove_portfolio $projekt)
    {
        $data = MTL_log::where([
            'id_pp' => $projekt->id,
            'week_number' => Carbon::now()->subWeek()->weekOfYear
            ]
        )
        ->first();

        if ($data != null) {
            $obj = new \stdClass();
            $obj->state = in_array($data->status, ['red', 'orange', 'green']) ? 1 : 0;
            $obj->value = in_array($data->status, ['red', 'orange', 'green']) ? $data->status : null;
            $obj->week_num = $data->week_number;
            return $obj;
        }

        $obj = new \stdClass();
        $obj->state = 0;
        $obj->value = null;
        $obj->week_num = null; // Set to null since no record exists
        return $obj;
    }

    public function getInterneUdaje(Projektove_portfolio $projekt, $dataset)
    {
        $interne_udaje=new \stdClass();

        $interne_udaje->reporting=$this->getReporting($projekt);
        $interne_udaje->reportingIsON=$this->isReportingON($projekt);
        $interne_udaje->planovanie_rozpoctu=$this->getPlanovanieRozpoctu($projekt);
        $interne_udaje->max_rok=$this->getMaxRok($projekt);
        $interne_udaje->poznamky=$this->getPoznamky($projekt);
        $interne_udaje->rgp_ready=$this->getRGPready($projekt);
        $interne_udaje->mtl=$this->getMTL_Log($projekt);
        $dataset->interne_udaje=$interne_udaje;
    }

    public function getSuvisProjektyCiselnik()
    {
        $results=Projektove_portfolio::orderBy('id_projekt')->select(['id_projekt','nazov_projektu','id'])->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->id;
            $obj->value=$item->id_projekt." - ".$item->nazov_projektu;
            $data[]=$obj;
        }
        return $data;
    }

    public function getManagersCiselnik()
    {
        $results=Managers::all();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=null;
            $obj->value=null;
            $data[]=$obj;
        }
        return $data;
    }

    public function getUsers()
    {
        $results=User::orderBy('name')->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->objectguid;
            $obj->value=$item->name;
            $obj->group_name=$item->department;
            $data[]=$obj;

//            if ($item->objectguid === "4c16d136-2d4e-4545-a2db-2108ac30a0b4")
//            {
//                $obj=new \stdClass();
//                $obj->id=$item->objectguid;
//                $obj->value=$item->name;
//                $obj->group_name=$item->department;
//                //dd($obj);
//                $data[]=$obj;
//            }
        }
        return $data;
    }

    public function getMagistratnyGarantUsers()
    {
        $results=User::where(['department'])->orderBy('name')->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->objectguid;
            $obj->value=$item->name;
            $obj->group_name=$item->department;
            $data[]=$obj;
        }
        return $data;
    }



    public function getGroups()
    {
        $results=Groups::whereNull('typ')->orderBy('cn')->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->objectguid;
            $obj->value=$item->cn;
            $obj->utvarOrganizacia="utvar";
            $obj->typ_organizacie=null;
            $obj->label="Útvar";
            $data[]=$obj;
        }
        return $data;
    }

    public function getOrganizacie()
    {
        $results=Groups::whereNotNull('typ')->orderBy('cn')->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->objectguid;
            $obj->value=$item->cn;
            $obj->utvarOrOrganizacia="organizacia";
            $obj->typ_organizacie=$item->typ;
            $obj->label="Organizácia - ".$item->typ;
            $data[]=$obj;
        }
        return $data;
    }

    public function getAktivityCiselnik()
    {
        $results=Aktivity::orderBy('id_kategoria')->get();
        $data=[];
        foreach ($results as $item)
        {
            $obj=new \stdClass();
            $obj->id=$item->id;
            $obj->name=$item->name;
            $obj->headerTitle=$item->Aktivity_Kategoria->value;
            $obj->flag="A";
            $obj->note=$item->note;
            $data[]=$obj;
        }
        return $data;
    }

    public function findAvailableId()
    {

//        $maxExistingID = Projektove_portfolio::where('id_projekt', '<', '9000')->max('id_projekt');
//        if ($maxExistingID < 2500) {
//            $maxExistingID = 2499; //2499 lebo return vrati o jedno viac, ciel je ziskat prvykrat 2500...
//        }
//        if ((Projektove_portfolio::where(['id_projekt' => $maxExistingID + 1])->first()) === null) //check ci take id uz existuje
//        {
//            return $maxExistingID + 1;
//        } else
    return null;

    }

    public function getNotAvailableId()
    {
        return Projektove_portfolio::pluck('id_projekt')->toArray();
    }

}

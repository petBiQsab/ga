<?php

namespace App\Http\Repositories;


use App\Http\Controllers\Auth\AuthCollection;
use App\Http\Interface\PracoviskoInterface;
use App\Http\Rights\ProjectUserRights;
use App\Models\Managers;
use App\Models\Projektove_portfolio;
use App\Models\Users_group;
use Carbon\Carbon;

class PracoviskoRepository implements PracoviskoInterface
{
    private $authConfig;

    /**
     * @param $authConfig
     */
    public function __construct(AuthCollection $authConfig)
    {
        $this->authConfig = $authConfig;
    }

    public function getMtlLogStatus($item,$dataset)
    {
        if ($item->PP_MTL_Log_last_week)
        {
            if ($this->isReportingON($item)==1 && $item->PP_MTL_Log_last_week->status !== 'none')
            {
                $dataset->mtl_log_status = "Zreportovaný";
            }elseif ($this->isReportingON($item)==1 && $item->PP_MTL_Log_last_week->status === 'none')
            {
                $dataset->mtl_log_status = "Nezreportovaný";
            }
            else{
                $dataset->mtl_log_status = null;
            }
        }
        else{
            $dataset->mtl_log_status = null;
        }

        return $dataset;
    }

    public function getMtl($item, $dataset)
    {
        if ($this->isReportingON($item)==1)
        {
            if (isset($item->PP_MTL->status))
            {
                $dataset->mtl=$item->PP_MTL->status ??= null;
                return $dataset;
            }
            else
            {
                $dataset->mtl=null;
                return $dataset;
            }
        }else
        {
            $dataset->mtl=null;
            return $dataset;
        }
    }

    public function getAtl($item, $dataset)
    {
        // Use the eager loaded relationship instead of querying the database
        $results = $item->incompleteActivities;

        if ($results && count($results) > 0) {
            $max_diff = '';

            foreach ($results as $result_item) {
                if ($result_item->zaciatok_aktivity !== null) {
                    $zaciatok_aktivity = Carbon::parse($result_item->zaciatok_aktivity)->floorMonth();

                    if ($result_item->skutocny_zaciatok_aktivity !== null) {
                        $skutocny_zaciatok_aktivity = Carbon::parse($result_item->skutocny_zaciatok_aktivity)->floorMonth();
                    } else {
                        $skutocny_zaciatok_aktivity = Carbon::now()->floorMonth();
                    }

                    $monthDiff = $skutocny_zaciatok_aktivity->diffInMonths($zaciatok_aktivity);

                    if (!$skutocny_zaciatok_aktivity->gt($zaciatok_aktivity)) {
                        $monthDiff *= -1;
                    }

                    if ($monthDiff > $max_diff) {
                        $max_diff = $monthDiff;
                    }
                }

                if ($result_item->koniec_aktivity !== null && $result_item->skutocny_koniec_aktivity === null) {
                    $koniec_aktivity = Carbon::parse($result_item->koniec_aktivity)->floorMonth();
                    $skutocny_koniec_aktivity = Carbon::now()->floorMonth();

                    $monthDiff = $skutocny_koniec_aktivity->diffInMonths($koniec_aktivity);

                    if (!$skutocny_koniec_aktivity->gt($koniec_aktivity)) {
                        $monthDiff *= -1;
                    }

                    if ($monthDiff > $max_diff) {
                        $max_diff = $monthDiff;
                    }
                } elseif ($result_item->koniec_aktivity !== null && $result_item->skutocny_koniec_aktivity !== null) {
                    $max_diff = 0;
                }
            }

            if ($max_diff !== '') {
                if ($max_diff <= 0) {
                    $dataset->atl = "green";
                } elseif ($max_diff <= 2 && $max_diff >= 1) {
                    $dataset->atl = "orange";
                } elseif ($max_diff > 2) {
                    $dataset->atl = "red";
                } else {
                    $dataset->atl = null;
                }
            } else {
                $dataset->atl = null;
            }
        } else {
            $dataset->atl = null;
        }

        return $dataset;
    }


    public function getNazovProjektu(Projektove_portfolio $item,  $dataset)
    {
        $dataset->nazov_projektu=$item->nazov_projektu;
        return $dataset;
    }

    public function getAltNazovProjektu($item,  $dataset)
    {
        $dataset->alt_nazov_projektu=$item->alt_nazov_projektu;
        return $dataset;
    }

    public function getCielProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->ciel_projektu = $item->PP_PP_Details->ciel_projektu;
            return $dataset;
        }else
        {
            $dataset->ciel_projektu=null;
            return $dataset;
        }
    }

    public function getStrategickyCielPHSR($item,  $dataset)
    {
        if (isset($item->PP_PHSR))
        {
            $phsr_data=$item->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $dataset->strategicky_ciel_PHSR=[];
                foreach ($phsr_data as $item)
                {

                    if (isset($item->PP_PHSR_Strateg_ciel))
                    {
                        $dataset->strategicky_ciel_PHSR[]=$item->PP_PHSR_Strateg_ciel->value;
                    }
                }
                return $dataset->strategicky_ciel_PHSR;
            }else
            {
                $dataset->strategicky_ciel_PHSR=[];
                return $dataset;
            }
        }else
        {
            $dataset->strategicky_ciel_PHSR=[];
            return $dataset;
        }
    }

    public function getSpecifickyCielPHSR($item,  $dataset)
    {
        if (isset($item->PP_PHSR))
        {
            $phsr_data=$item->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $dataset->specificky_ciel_PHSR=[];
                foreach ($phsr_data as $item)
                {
                    if (isset($item->PP_PHSR_Speci_ciel))
                    {
                        $dataset->specificky_ciel_PHSR[]=$item->PP_PHSR_Speci_ciel->value;
                    }
                }
                return $dataset->specificky_ciel_PHSR;
            }else
            {
                $dataset->specificky_ciel_PHSR=[];
                return $dataset;
            }
        }else
        {
            $dataset->speci_ciel_PHSR=[];
            return $dataset;
        }
    }

    public function getProgram($item,  $dataset)
    {
        if (isset($item->PP_PHSR))
        {
            $phsr_data=$item->PP_PHSR;
            if (count($phsr_data)>0)
            {
                $dataset->program=[];
                foreach ($phsr_data as $item)
                {
                    if (isset($item->PP_PHSR_Program))
                    {
                        $dataset->program[]=$item->PP_PHSR_Program->value;
                    }
                }
                return $dataset->program;
            }else
            {
                $dataset->program=[];
                return $dataset;
            }
        }else
        {
            $dataset->program=[];
            return $dataset;
        }
    }

    public function getMeratelnyVystupovyUkazovatel($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->meratelny_vystupovy_ukazovatel = $item->PP_PP_Details->meratelny_vystupovy_ukazovatel;
            return $dataset;
        }else
        {
            $dataset->meratelny_vystupovy_ukazovatel=null;
            return $dataset;
        }
    }

    public function getTypProjektu($item,  $dataset)
    {
        if (isset($item->PP_TypProjektu))
        {
            $data=$item->PP_TypProjektu;
            if (count($data)>0)
            {
                $dataset->typ_projektu=[];
                foreach ($data as $item)
                {
                    if (isset($item->TypProjektuPP_TypProjektu))
                    {
                        $dataset->typ_projektu[]=$item->TypProjektuPP_TypProjektu->value;
                    }
                }
                return $dataset->typ_projektu;
            }else
            {
                $dataset->typ_projektu=[];
                return $dataset;
            }
        }else
        {
            $dataset->typ_projektu=[];
            return $dataset;
        }
    }

    public function getKategoriaProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            if (isset($item->PP_PP_Details->PP_Details_Kategoria))
            {
                $dataset->kategoria_projektu = $item->PP_PP_Details->PP_Details_Kategoria->value;
                return $dataset;
            }
            else
            {
                $dataset->kategoria_projektu = null;
                return $dataset;
            }
        }else
        {
            $dataset->kategoria_projektu=null;
            return $dataset;
        }
    }
    public function getRyg($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            if (isset($item->PP_PP_Details->PP_Details_Ryg))
            {
                $dataset->ryg = $item->PP_PP_Details->PP_Details_Ryg->value;
                return $dataset;
            }
            else
            {
                $dataset->ryg = null;
                return $dataset;
            }
        }else
        {
            $dataset->ryg=null;
            return $dataset;
        }
    }

    public function getMuscow($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            if (isset($item->PP_PP_Details->PP_Details_Muscow))
            {
                $dataset->muscow = $item->PP_PP_Details->PP_Details_Muscow->value;
                return $dataset;
            }
            else
            {
                $dataset->muscow = null;
                return $dataset;
            }
        }else
        {
            $dataset->muscow=null;
            return $dataset;
        }
    }

    public function getPrioritneOblasti($item,  $dataset)
    {
        if (isset($item->PP_PrioritneOblasti))
        {
            $data=$item->PP_PrioritneOblasti;
            if (count($data)>0)
            {
                $dataset->prioritne_oblasti=[];
                foreach ($data as $item)
                {
                    if (isset($item->PrioritneOblastiPP_PrioritneOblasti))
                    {
                        $dataset->prioritne_oblasti[]=$item->PrioritneOblastiPP_PrioritneOblasti->value;
                    }
                }
                return $dataset->prioritne_oblasti;
            }else
            {
                $dataset->prioritne_oblasti=[];
                return $dataset;
            }
        }else
        {
            $dataset->prioritne_oblasti=[];
            return $dataset;
        }
    }

    public function getPlanovanieRozpoctu($item,  $dataset)
    {
        if (isset($item->PP_Planovanie_rozpoctu)) {

            $dataset->planovanie_rozpoctu = $item->PP_Planovanie_rozpoctu->value;
            return $dataset;
        }else
        {
            $dataset->planovanie_rozpoctu=null;
            return $dataset;
        }
    }

    public function getDatumZacatiaProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->datum_zacatia_projektu = $item->PP_PP_Details->datum_zacatia_projektu;
            return $dataset;
        }else
        {
            $dataset->datum_zacatia_projektu=null;
            return $dataset;
        }
    }

    public function getDatumKoncaProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->datum_konca_projektu = $item->PP_PP_Details->datum_konca_projektu;
            return $dataset;
        }else
        {
            $dataset->datum_konca_projektu=null;
            return $dataset;
        }
    }

    public function getStavProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            if (isset($item->PP_PP_Details->PP_Details_Stav_projektu))
            {
                $dataset->stav_projektu = $item->PP_PP_Details->PP_Details_Stav_projektu->value;
                return $dataset;
            }
            else
            {
                $dataset->stav_projektu = null;
                return $dataset;
            }
        }else
        {
            $dataset->stav_projektu=null;
            return $dataset;
        }
    }

    public function getFazaProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            if (isset($item->PP_PP_Details->PP_Details_Faza_projektu))
            {
                $dataset->faza_projektu = $item->PP_PP_Details->PP_Details_Faza_projektu->value;
                return $dataset;
            }
            else
            {
                $dataset->faza_projektu = null;
                return $dataset;
            }
        }else
        {
            $dataset->faza_projektu=null;
            return $dataset;
        }
    }

    public function getZrealizovaneAktivity($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->zrealizovane_aktivity = $item->PP_PP_Details->zrealizovane_aktivity;
            return $dataset;
        }else
        {
            $dataset->zrealizovane_aktivity=null;
            return $dataset;
        }
    }

    public function getPlanovaneAktivity($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->planovane_aktivity = $item->PP_PP_Details->planovane_aktivity_na_najblizsi_tyzden;
            return $dataset;
        }else
        {
            $dataset->planovane_aktivity=null;
            return $dataset;
        }
    }

    public function getRizikaProjektu($item,  $dataset)
    {
        if (isset($item->PP_PP_Details)) {
            $dataset->rizika_projektu = $item->PP_PP_Details->rizika_projektu;
            return $dataset;
        }else
        {
            $dataset->rizika_projektu=null;
            return $dataset;
        }
    }

    public function getPoslednaUkoncenaAktivita($item, $dataset)
    {
        $aktivita = $item->lastCompletedActivity;

        if ($aktivita) {
            if ($aktivita->vlastna_aktivita !== null) {
                $aktivita_value = $aktivita->vlastna_aktivita;
            } elseif ($aktivita->id_aktivita !== null) {
                $aktivita_value = $aktivita->AktivityPP_Aktivity->name;
            } else {
                $aktivita_value = null;
            }
        } else {
            $aktivita_value = null;
        }

        $dataset->posledna_ukoncena_aktivita = $aktivita_value;
        return $dataset;
    }

    public function getZadavatelProjektu($item,  $dataset)
    {
        if (isset($item->PP_OrganizaciaProjektu)) {
            if (isset($item->PP_OrganizaciaProjektu->OrganizaciaProjektu_Groups_Zadavatel))
            {
                $dataset->zadavatel_projektu = $item->PP_OrganizaciaProjektu->OrganizaciaProjektu_Groups_Zadavatel->cn;
                return $dataset;
            }
            else
            {
                $dataset->zadavatel_projektu = null;
                return $dataset;
            }
        }else
        {
            $dataset->zadavatel_projektu=null;
            return $dataset;
        }
    }

    public function getPolitickyGarant($item, $dataset)
    {
        if (isset($item->PP_OrganizaciaProjektu)) {
            if (isset($item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_PolitickyGarant))
            {
                $dataset->politicky_garant = $item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_PolitickyGarant->name;
                return $dataset;
            }
            else
            {
                $dataset->politicky_garant = null;
                return $dataset;
            }
        }else
        {
            $dataset->politicky_garant=null;
            return $dataset;
        }
    }

    public function getMagistratnyGarant($item, $dataset)
    {
        if (isset($item->PP_OrganizaciaProjektu)) {
            if (isset($item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_MagistratnyGarant))
            {
                $dataset->magistratny_garant = $item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_MagistratnyGarant->name;
                return $dataset;
            }
            else
            {
                $dataset->magistratny_garant = null;
                return $dataset;
            }
        }else
        {
            $dataset->magistratny_garant=null;
            return $dataset;
        }
    }

    public function getProjektovyGarant($item,  $dataset)
    {
        if (isset($item->PP_OrganizaciaProjektu)) {
            if (isset($item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_Garant))
            {
                $dataset->projektovy_garant = $item->PP_OrganizaciaProjektu->OrganizaciaProjektu_User_Garant->name;
                return $dataset;
            }
            else
            {
                $dataset->projektovy_garant = null;
                return $dataset;
            }
        }else
        {
            $dataset->projektovy_garant=null;
            return $dataset;
        }
    }

    public function getUtvarProjektovehoManagera($item,  $dataset)
    {
        if (isset($item->PP_ProjektovyManager))
        {
            $data=$item->PP_ProjektovyManager;
            if (count($data)>0)
            {
                $dataset->utvar_projektoveho_manazera=[];
                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyManagerPP_User))
                    {
                        if (isset($item->ProjektovyManagerPP_User->department))
                        {
                            $dataset->utvar_projektoveho_manazera[]=$item->ProjektovyManagerPP_User->department;
                        }
                    }
                }
                return $dataset;
            }else
            {
                $dataset->utvar_projektoveho_manazera=[];
                return $dataset;
            }
        }else
        {
            $dataset->utvar_projektoveho_manazera=[];
            return $dataset;
        }
    }

    public function getProjektovyManager($item,  $dataset)
    {
        if (isset($item->PP_ProjektovyManager))
        {
            $data=$item->PP_ProjektovyManager;
            if (count($data)>0)
            {
                $dataset->projektovy_manazer=[];
                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyManagerPP_User))
                    {
                        $dataset->projektovy_manazer[]=$item->ProjektovyManagerPP_User->name;
                    }
                }
                return $dataset->projektovy_manazer;
            }else
            {
                $dataset->projektovy_manazer=[];
                return $dataset;
            }
        }else
        {
            $dataset->projektovy_manazer=[];
            return $dataset;
        }
    }

    public function getProjektovyManagerPM($item,  $dataset)
    {
        if (isset($item->PP_ProjektovyManager))
        {
            $data=$item->PP_ProjektovyManager;
            if (count($data)>0)
            {

                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyManagerPP_User))
                    {
                        $projektovy_manazer[]=$item->ProjektovyManagerPP_User->objectguid;
                    }
                }
                return $projektovy_manazer;
            }else
            {
                $projektovy_manazer=[];
                return $projektovy_manazer;
            }
        }else
        {
            $projektovy_manazer=[];
            return $projektovy_manazer;
        }
    }
    public function getCoopUtvary($item,  $dataset)
    {
        if (isset($item->PP_CoopUtvary))
        {
            $data=$item->PP_CoopUtvary;
            if (count($data)>0)
            {

                $dataset->coop_utvary=[];
                foreach ($data as $item)
                {
                    if (isset($item->CoopUtvary_Groups))
                    {
                        $dataset->coop_utvary[]=$item->CoopUtvary_Groups->cn;
                    }
                }
                return $dataset->coop_utvary;
            }else
            {
                $dataset->coop_utvary=[];
                return $dataset;
            }
        }else
        {
            $dataset->coop_utvary=[];
            return $dataset;
        }
    }

    public function getCoopOrganizacie($item,  $dataset)
    {
        if (isset($item->PP_CoopOrganizacie))
        {
            $data=$item->PP_CoopOrganizacie;
            if (count($data)>0)
            {
                $dataset->coop_organizacie=[];
                foreach ($data as $item)
                {
                    if (isset($item->CoopOrganizacie_Groups))
                    {
                        $dataset->coop_organizacie[]=$item->CoopOrganizacie_Groups->cn;
                    }
                }
                return $dataset->coop_organizacie;
            }else
            {
                $dataset->coop_organizacie=[];
                return $dataset;
            }
        }else
        {
            $dataset->coop_organizacie=[];
            return $dataset;
        }
    }

    public function getProjektovyTim($item,  $dataset)
    {

        if (isset($item->PP_ProjektovyTim))
        {
            $data=$item->PP_ProjektovyTim;
            if (count($data)>0)
            {
                $dataset->projektovy_tim=[];
                foreach ($data as $item)
                {
                    if (isset($item->ProjektovyTim_User))
                    {
                        $dataset->projektovy_tim[]=$item->ProjektovyTim_User->name;
                    }
                }

                return $dataset->projektovy_tim;
            }else
            {
                $dataset->projektovy_tim[]=null;
                return $dataset;
            }
        }else
        {
            $dataset->projektovy_tim[]=null;
            return $dataset;
        }
    }

    public function getUdrzba($item, $dataset)
    {
        if (isset($item->PP_Udrzba))
        {
            $data=$item->PP_Udrzba;
            if (count($data)>0)
            {
                $dataset->udrzba=[];
                foreach ($data as $item)
                {
                    if (isset($item->Udrzba_Groups))
                    {
                        $dataset->udrzba[]=$item->Udrzba_Groups->cn;
                    }
                }
                return $dataset->udrzba;
            }else
            {
                $dataset->udrzba=[];
                return $dataset;
            }
        }else
        {
            $dataset->udrzba=[];
            return $dataset;
        }
    }

    public function getSprava($item, $dataset)
    {
        if (isset($item->PP_Sprava))
        {
            $data=$item->PP_Sprava;
            if (count($data)>0)
            {
                $dataset->sprava=[];
                foreach ($data as $item)
                {
                    if (isset($item->Sprava_Groups))
                    {
                        $dataset->sprava[]=$item->Sprava_Groups->cn;
                    }
                }
                return $dataset->sprava;
            }else
            {
                $dataset->sprava=[];
                return $dataset;
            }
        }else
        {
            $dataset->sprava=[];
            return $dataset;
        }
    }

    public function getRiadiaceGremium($item,  $dataset)
    {
        if (isset($item->PP_RiadiaceGremium))
        {
            $data=$item->PP_RiadiaceGremium;
            if (count($data)>0)
            {
                $dataset->riadiace_gremium=[];
                foreach ($data as $item)
                {
                    if (isset($item->RiadiaceGremium_User))
                    {
                        $dataset->riadiace_gremium[]=$item->RiadiaceGremium_User->name;
                    }
                }
                return $dataset->riadiace_gremium;
            }else
            {
                $dataset->riadiace_gremium=[];
                return $dataset;
            }
        }else
        {
            $dataset->riadiace_gremium=[];
            return $dataset;
        }
    }

    public function getDatumSchvaleniaPIPG($item,  $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->datum_schvalenie_pi_na_pg = $item->PP_SchvalovanieProjektu->datum_schvalenia_pi_na_pg;
            return $dataset;
        }
        else
        {
            $dataset->datum_schvalenie_pi_na_pg=null;
            return $dataset;
        }
    }

    public function getDatumSchvaleniaPZPG($item,  $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->datum_schvalenie_pz_na_pg = $item->PP_SchvalovanieProjektu->datum_schvalenia_pz_na_pg;
            return $dataset;
        }
        else
        {
            $dataset->datum_schvalenie_pz_na_pg=null;
            return $dataset;
        }
    }

    public function getSumaExternehoFinancovania($item,  $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            $dataset->suma_externeho_financovania = $item->PP_DoplnujuceUdaje->suma_externeho_financovania;
            return $dataset;
        }
        else
        {
            $dataset->suma_externeho_financovania=null;
            return $dataset;
        }
    }

    public function getZdrojExternehoFinancovania($item,  $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            $dataset->zdroj_externeho_financovania = $item->PP_DoplnujuceUdaje->zdroj_externeho_financovania;
            return $dataset;
        }
        else
        {
            $dataset->zdroj_externeho_financovania=null;
            return $dataset;
        }
    }

    public function getMestskaCast($item,  $dataset)
    {
        if (isset($item->PP_MestskaCastPP))
        {
            $data=$item->PP_MestskaCastPP;
            if (count($data)>0)
            {
                $dataset->mestska_cast=[];
                foreach ($data as $item)
                {
                    if (isset($item->MestkaCastPP_MestskaCast))
                    {
                        $dataset->mestska_cast[]=$item->MestkaCastPP_MestskaCast->value;
                    }
                }
                return $dataset->mestska_cast;
            }else
            {
                $dataset->mestska_cast=[];
                return $dataset;
            }
        }else
        {
            $dataset->mestska_cast=[];
            return $dataset;
        }
    }

    public function getPriorita($item,  $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            $dataset->priorita = $item->PP_DoplnujuceUdaje->priorita;
            return $dataset;
        }
        else
        {
            $dataset->priorita=null;
            return $dataset;
        }
    }

    public function getVerejnaPraca($item,  $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {
            if (isset($item->PP_DoplnujuceUdaje->Doplnujuce_udaje_VerejnaPraca))
            {
                $dataset->verejna_praca = $item->PP_DoplnujuceUdaje->Doplnujuce_udaje_VerejnaPraca->value;
                return $dataset;
            }
        }
        else
        {
            $dataset->verejna_praca=null;
            return $dataset;
        }
    }

    public function getSpecifickeAtributy($item,  $dataset)
    {
        if (isset($item->PP_SpeciAtributPP))
        {
            $data=$item->PP_SpeciAtributPP;
            if (count($data)>0)
            {
                $dataset->specificke_atributy=[];
                foreach ($data as $item)
                {
                    if (isset($item->SpeciAtributPP_SpeciAtribut))
                    {
                        $dataset->specificke_atributy[]=$item->SpeciAtributPP_SpeciAtribut->value;
                    }
                }
                return $dataset->specificke_atributy;
            }else
            {
                $dataset->specificke_atributy=[];
                return $dataset;
            }
        }else
        {
            $dataset->specificke_atributy=[];
            return $dataset;
        }
    }

    public function getHashtagy($item,  $dataset)
    {
        if (isset($item->PP_HashtagPP))
        {
            $data=$item->PP_HashtagPP;
            if (count($data)>0)
            {
                $dataset->hashtagy=[];
                foreach ($data as $item)
                {
                    if (isset($item->HashtagPP_Hashtag))
                    {
                        $dataset->hashtagy[]=$item->HashtagPP_Hashtag->value;
                    }
                }
                return $dataset->hashtagy;
            }else
            {
                $dataset->hashtagy=[];
                return $dataset;
            }
        }else
        {
            $dataset->hashtagy=[];
            return $dataset;
        }
    }

    public function getReporting($item,  $dataset)
    {
        if (isset($item->PP_Reporting)) {

            $dataset->reporting = $item->PP_Reporting->value;
            return $dataset;
        }
        else
        {
            $dataset->reporting=null;
            return $dataset;
        }

    }

    public function getReportingFilter($item,  $dataset)
    {
        //reporting_filter to sleduje jozo..
        //TODO 2 je ak je nezreportovane
        //TODO 1 je ak je zreportovane
        //TODO 0 ak je vypnutý reporting

    }

    public function getRole($id_user,$id_projekt,$dataset)
    {
        $userRight=new ProjectUserRights();
        $userRightName=$userRight->getRightsForProject($id_user,$id_projekt);
        $dataset->role=$userRightName->slug;
        return $dataset;

    }

    public function filterByUserRights($dataset)
    {
        foreach ($dataset as $project_item) {

            $role = $project_item->role;

            $commonKeysBasic = array_intersect_key(get_object_vars($project_item), array_flip($this->authConfig->getByKeyAndType(strtolower($role), "hide")));

            foreach ($commonKeysBasic as $key => $value) {
                if (array_key_exists($key, get_object_vars($project_item))) {

                    $project_item->$key = null;
                }
            }

        }
        return $dataset;
    }

    public function createDataset()
    {
        $dataset=[];
        $projekty=Projektove_portfolio::with('PP_PP_Details','PP_PHSR','PP_DoplnujuceUdaje','PP_OrganizaciaProjektu','PP_TypProjektu','PP_MestskaCastPP','PP_SpeciAtributPP','PP_HashtagPP','PP_SchvalovanieProjektu','PP_Planovanie_rozpoctu','PP_ProjektovyManager','PP_Udrzba','PP_Sprava','PP_CoopUtvary','PP_CoopOrganizacie','PP_MTL','PP_Reporting','PP_PrioritneOblasti','PP_SuvisiaceProjekty','PP_ProjektovyTim','PP_RiadiaceGremium','lastCompletedActivity','incompleteActivities')->orderBy('id_projekt')->get();

        foreach ($projekty as $item)
        {
            $data=new \stdClass();
            $data->id=$item->id_projekt;
            $data->id_original=$item->id_original;
            $this->getMtl($item,$data);
            $this->getMtlLogStatus($item,$data);
            $this->getAtl($item,$data);
            $this->getNazovProjektu($item,$data);
            $this->getAltNazovProjektu($item,$data);
            $this->getCielProjektu($item,$data);
            $this->getStrategickyCielPHSR($item,$data);
            $this->getSpecifickyCielPHSR($item,$data);
            $this->getProgram($item,$data);
            $this->getMeratelnyVystupovyUkazovatel($item,$data);
            $this->getTypProjektu($item,$data);
            $this->getKategoriaProjektu($item,$data);
            $this->getPrioritneOblasti($item,$data);
            $this->getPlanovanieRozpoctu($item,$data);
            $this->getDatumZacatiaProjektu($item,$data);
            $this->getDatumKoncaProjektu($item,$data);
            $this->getStavProjektu($item,$data);
            $this->getFazaProjektu($item,$data);
            $this->getZrealizovaneAktivity($item,$data);
            $this->getPlanovaneAktivity($item,$data);
            $this->getRizikaProjektu($item,$data);
            $this->getPoslednaUkoncenaAktivita($item,$data);
            $this->getMagistratnyGarant($item,$data);
            $this->getPolitickyGarant($item,$data);
            $this->getZadavatelProjektu($item,$data);
            $this->getProjektovyGarant($item,$data);
            $this->getUtvarProjektovehoManagera($item,$data);
            $this->getProjektovyManager($item,$data);
            $this->getCoopUtvary($item,$data);
            $this->getCoopOrganizacie($item,$data);
            $this->getProjektovyTim($item,$data);
            $this->getSprava($item,$data);
            $this->getUdrzba($item,$data);
            $this->getRiadiaceGremium($item,$data);
            $this->getDatumSchvaleniaPIPG($item,$data);
            $this->getDatumSchvaleniaPZPG($item,$data);
            $this->getDatumSchvaleniaProjektuPPP($item,$data);
            $this->getDatumSchvaleniaProjektuMsZ($item,$data);
            $this->getSumaExternehoFinancovania($item,$data);
            $this->getZdrojExternehoFinancovania($item,$data);
            $this->getMestskaCast($item,$data);
            $this->getPriorita($item,$data);
            $this->getPriorityOld($item,$data);
            $this->getSpecifickeAtributy($item,$data);
            $this->getHashtagy($item,$data);
            $this->getReporting($item,$data);
            $this->getExterniStakeholderi($item, $data);
            $this->getDatumSchvaleniaProjektu($item, $data);
            $this->getSchvaleniePIPG($item, $data);
            $this->getHyperlinkPI($item, $data);
            $this->getPripomienkyPI($item, $data);
            $this->getSchvaleniePZPG($item, $data);
            $this->getHyperlinkPZ($item, $data);
            $this->getPripomienkyPZ($item, $data);
            $this->getExterneFinancovanie($item, $data);
            $this->getPodielExtFinancovania($item, $data);
            $this->getSuvisiaceProjekty($item, $data);
            $this->getHyperlinkUloziskoProjektu($item, $data);
            $this->getNajaktualnejsiaCenaProjektuDPH($item, $data);
            $this->getNajaktualRocnePrevadzkoveNakladyProjektuDPH($item, $data);
            $this->getMaxRok($item, $data);
            $this->getPoznamky($item, $data);
            $this->getRyg($item, $data);
            $this->getMuscow($item, $data);
            $this->getVerejnaPraca($item, $data);
            $this->getRole(auth()->user()->objectguid,$item->id,$data);

            $dataset[]=$data;
        }
        $dataset=$this->filterByUserRights($dataset);

        return $dataset;
    }


    public function createDatasetPM($objectguid)
    {

        $dataset=[];
        $projekty=Projektove_portfolio::orderBy('id_projekt')->get();

        foreach ($projekty as $item)
        {
            $data=new \stdClass();
            $data->id=$item->id_projekt;
            $data->id_original=$item->id_original;
            $this->getMtl($item,$data);
            $this->getAtl($item,$data);
            $this->getNazovProjektu($item,$data);
            $this->getAltNazovProjektu($item,$data);
            $this->getCielProjektu($item,$data);
            $this->getStrategickyCielPHSR($item,$data);
            $this->getSpecifickyCielPHSR($item,$data);
            $this->getProgram($item,$data);
            $this->getMeratelnyVystupovyUkazovatel($item,$data);
            $this->getTypProjektu($item,$data);
            $this->getKategoriaProjektu($item,$data);
            $this->getPrioritneOblasti($item,$data);
            $this->getPlanovanieRozpoctu($item,$data);
            $this->getDatumZacatiaProjektu($item,$data);
            $this->getDatumKoncaProjektu($item,$data);
            $this->getStavProjektu($item,$data);
            $this->getFazaProjektu($item,$data);
            $this->getPoslednaUkoncenaAktivita($item,$data);
            $this->getMagistratnyGarant($item,$data);
            $this->getPolitickyGarant($item,$data);
            $this->getZadavatelProjektu($item,$data);
            $this->getProjektovyGarant($item,$data);
            $this->getUtvarProjektovehoManagera($item,$data);
            $this->getProjektovyManager($item,$data);
            if(!in_array($objectguid,$this->getProjektovyManagerPM($item,$data)))
            {
                continue;
            }
            $this->getCoopUtvary($item,$data);
            $this->getCoopOrganizacie($item,$data);
            $this->getProjektovyTim($item,$data);
            $this->getSprava($item,$data);
            $this->getUdrzba($item,$data);
            $this->getRiadiaceGremium($item,$data);
            $this->getDatumSchvaleniaPIPG($item,$data);
            $this->getDatumSchvaleniaPZPG($item,$data);
            $this->getSumaExternehoFinancovania($item,$data);
            $this->getZdrojExternehoFinancovania($item,$data);
            $this->getMestskaCast($item,$data);
            $this->getPriorita($item,$data);
            $this->getSpecifickeAtributy($item,$data);
            $this->getHashtagy($item,$data);
            $this->getReporting($item,$data);
            $this->getRyg($item, $data);
            $this->getMuscow($item, $data);

            $this->getRole(auth()->user()->objectguid,$item->id,$data);
            $dataset[]=$data;
        }
        $dataset=$this->filterByUserRights($dataset);

        return $dataset;
    }



    public function createDatasetLimit($number)
    {

        $dataset=[];
        $projekty=Projektove_portfolio::orderBy('id_projekt')->limit($number)->get();

        foreach ($projekty as $item)
        {
            $data=new \stdClass();
            $data->id=$item->id_projekt;
            $data->id_original=$item->id_original;
            $this->getMtl($item,$data);
            $this->getAtl($item,$data);
            $this->getNazovProjektu($item,$data);
            $this->getAltNazovProjektu($item,$data);
            $this->getCielProjektu($item,$data);
            $this->getStrategickyCielPHSR($item,$data);
            $this->getSpecifickyCielPHSR($item,$data);
            $this->getProgram($item,$data);
            $this->getMeratelnyVystupovyUkazovatel($item,$data);
            $this->getTypProjektu($item,$data);
            $this->getKategoriaProjektu($item,$data);
            $this->getPrioritneOblasti($item,$data);
            $this->getPlanovanieRozpoctu($item,$data);
            $this->getDatumZacatiaProjektu($item,$data);
            $this->getDatumKoncaProjektu($item,$data);
            $this->getStavProjektu($item,$data);
            $this->getFazaProjektu($item,$data);
            $this->getPoslednaUkoncenaAktivita($item,$data);
            $this->getMagistratnyGarant($item,$data);
            $this->getPolitickyGarant($item,$data);
            $this->getZadavatelProjektu($item,$data);
            $this->getProjektovyGarant($item,$data);
            $this->getUtvarProjektovehoManagera($item,$data);
            $this->getProjektovyManager($item,$data);
            $this->getCoopUtvary($item,$data);
            $this->getCoopOrganizacie($item,$data);
            $this->getProjektovyTim($item,$data);
            $this->getSprava($item,$data);
            $this->getUdrzba($item,$data);
            $this->getRiadiaceGremium($item,$data);
            $this->getDatumSchvaleniaPIPG($item,$data);
            $this->getDatumSchvaleniaPZPG($item,$data);
            $this->getDatumSchvaleniaProjektuPPP($item,$data);
            $this->getDatumSchvaleniaProjektuMsZ($item,$data);
            $this->getSumaExternehoFinancovania($item,$data);
            $this->getZdrojExternehoFinancovania($item,$data);
            $this->getMestskaCast($item,$data);
            $this->getPriorita($item,$data);
            $this->getPriorityOld($item,$data);
            $this->getSpecifickeAtributy($item,$data);
            $this->getHashtagy($item,$data);
            $this->getReporting($item,$data);
            $this->getExterniStakeholderi($item, $data);
            $this->getDatumSchvaleniaProjektu($item, $data);
            $this->getSchvaleniePIPG($item, $data);
            $this->getHyperlinkPI($item, $data);
            $this->getPripomienkyPI($item, $data);
            $this->getSchvaleniePZPG($item, $data);
            $this->getHyperlinkPZ($item, $data);
            $this->getPripomienkyPZ($item, $data);
            $this->getExterneFinancovanie($item, $data);
            $this->getPodielExtFinancovania($item, $data);
            $this->getSuvisiaceProjekty($item, $data);
            $this->getHyperlinkUloziskoProjektu($item, $data);
            $this->getNajaktualnejsiaCenaProjektuDPH($item, $data);
            $this->getNajaktualRocnePrevadzkoveNakladyProjektuDPH($item, $data);
            $this->getMaxRok($item, $data);
            $this->getPoznamky($item, $data);
            $this->getRyg($item, $data);
            $this->getMuscow($item, $data);
            $this->getZrealizovaneAktivity($item, $data);
            $this->getRole(auth()->user()->objectguid,$item->id,$data);

            if (!isset(auth()->user()->objectguid))
            {
                $objectguid="023f8e7f-d2fa-4ba5-9cf6-b69737111005";
            }else
            {
                $objectguid=auth()->user()->objectguid;
                //commitline
            }
            $this->getRole($objectguid,$item->id,$data);
            $dataset[]=$data;
        }
        $dataset=$this->filterByUserRights($dataset);

        return $dataset;
    }

    public function isReportingON(Projektove_portfolio $projekt)
    {
        $reportingState=null;
        if (isset($projekt->PP_Reporting))
        {
            $reportingState=$projekt->id_reporting;
        }

        if ($reportingState==1)
        {
            return 1;
        }
        return 0;
    }

    public function getMojeUtvary($id_user)
    {
        $list=[];

        $manager=Managers::where(['id_user'=>$id_user])->first();
        if ($manager!=null)
        {
            $utvary=Users_group::where(['group_id' => $manager->id_group])->whereNotNull('group')->get();
            if (count($utvary)>0)
            {
                foreach ($utvary as $item)
                {
                    $list[]=$item->UsersGroup_Group->cn;
                }
            }
        }

        $my_dep=Users_group::where(['user_id' => $id_user])->whereNotNull('group')->first();
        if ($my_dep!=null)
        {
            $list[]=$my_dep->UsersGroup_Group->cn;
        }

        return array_unique($list);
    }

    public function getPriority($item, $dataset)
    {
        if ($item->PP_DoplnujuceUdaje->id_priorita_new==1 or $item->PP_DoplnujuceUdaje->id_priorita_new==2)
        {
            $dataset->priorita=1;
            return $dataset;
        }else
        {
            $dataset->priorita=null;
            return $dataset;
        }
    }

    public function getPriorityOld($item, $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            if (isset($item->PP_DoplnujuceUdaje->Doplnujuce_udaje_Priorita)) {
                $dataset->id_priorita = $item->PP_DoplnujuceUdaje->Doplnujuce_udaje_Priorita->value;
                return $dataset;
            }else
            {
                $dataset->id_priorita=null;
                return $dataset;
            }
        }
        else
        {
            $dataset->id_externe_financovanie=null;
            return $dataset;
        }
    }

    public function getDatumSchvaleniaProjektuPPP($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->datum_schvalenia_projektu_ppp = $item->PP_SchvalovanieProjektu->datum_schvalenia_projektu_ppp;
            return $dataset;
        }
        else
        {
            $dataset->datum_schvalenia_projektu_ppp=null;
            return $dataset;
        }
    }

    public function getDatumSchvaleniaProjektuMsZ($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->datum_schvalenia_projektu_ppp = $item->PP_SchvalovanieProjektu->datum_schvalenia_projektu_msz;
            return $dataset;
        }
        else
        {
            $dataset->datum_schvalenia_projektu_msz=null;
            return $dataset;
        }
    }

    public function getExterniStakeholderi($item, $dataset)
    {
        if (isset($item->PP_OrganizaciaProjektu)) {

            $dataset->externi_stakeholderi = $item->PP_OrganizaciaProjektu->externi_stakeholderi;
            return $dataset;
        }
        else
        {
            $dataset->externi_stakeholderi=null;
            return $dataset;
        }
    }

    public function getDatumSchvaleniaProjektu($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->datum_schvalenia_ID = $item->PP_SchvalovanieProjektu->datum_schvalenia_ID;
            return $dataset;
        }
        else
        {
            $dataset->datum_schvalenia_ID=null;
            return $dataset;
        }
    }

    public function getSchvaleniePIPG($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {
            if (isset($item->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPIPG)) {
                $dataset->id_schvalenie_pi_na_pg = $item->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPIPG->value;
                return $dataset;
            }else
            {
                $dataset->id_schvalenie_pi_na_pg=null;
                return $dataset;
            }
        }
        else
        {
            $dataset->id_schvalenie_pi_na_pg=null;
            return $dataset;
        }
    }

    public function getHyperlinkPI($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->hyperlink_na_pi = $item->PP_SchvalovanieProjektu->hyperlink_na_pi;
            return $dataset;
        }
        else
        {
            $dataset->hyperlink_na_pi=null;
            return $dataset;
        }
    }

    public function getPripomienkyPI($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->pripomienky_k_pi = $item->PP_SchvalovanieProjektu->pripomienky_k_pi;
            return $dataset;
        }
        else
        {
            $dataset->pripomienky_k_pi=null;
            return $dataset;
        }
    }

    public function getSchvaleniePZPG($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            if (isset($item->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPZPG)) {
                $dataset->id_schvalenie_pz_na_pg = $item->PP_SchvalovanieProjektu->SchvalovanieProjektu_AkceptaciaPZPG->value;
                return $dataset;
            }else
            {
                $dataset->id_schvalenie_pz_na_pg=null;
                return $dataset;
            }
        }
        else
        {
            $dataset->id_schvalenie_pz_na_pg=null;
            return $dataset;
        }
    }

    public function getHyperlinkPZ($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->hyperlink_na_pz = $item->PP_SchvalovanieProjektu->hyperlink_na_pz;
            return $dataset;
        }
        else
        {
            $dataset->hyperlink_na_pz=null;
            return $dataset;
        }
    }

    public function getPripomienkyPZ($item, $dataset)
    {
        if (isset($item->PP_SchvalovanieProjektu)) {

            $dataset->pripomienky_k_pz = $item->PP_SchvalovanieProjektu->pripomienky_k_pz;
            return $dataset;
        }
        else
        {
            $dataset->pripomienky_k_pz=null;
            return $dataset;
        }
    }

    public function getExterneFinancovanie($item, $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            if (isset($item->PP_DoplnujuceUdaje->Doplnujuce_udaje_ExterneFinancovanie)) {
                $dataset->id_externe_financovanie = $item->PP_DoplnujuceUdaje->Doplnujuce_udaje_ExterneFinancovanie->value;
                return $dataset;
            }else
            {
                $dataset->id_externe_financovanie=null;
                return $dataset;
            }
        }
        else
        {
            $dataset->id_externe_financovanie=null;
            return $dataset;
        }
    }

    public function getPodielExtFinancovania($item, $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            $dataset->podiel_externeho_financovania_z_celkovej_ceny = $item->PP_DoplnujuceUdaje->podiel_externeho_financovania_z_celkovej_ceny;
            return $dataset;
        }
        else
        {
            $dataset->podiel_externeho_financovania_z_celkovej_ceny=null;
            return $dataset;
        }
    }

    public function getSuvisiaceProjekty($item, $dataset)
    {
        if (count($item->PP_SuvisiaceProjekty)>0)
        {
            $data=$item->PP_SuvisiaceProjekty;
            $output=[];
            foreach ($data as $item)
            {
                $output[] = $item->SuvisiaceProjekty_PP->id_projekt;
            }
            if (count($output) > 1) {
                $output = implode(', ', $output);
            } else {
                $output = implode('', $output); // Or just $string = $array[0]; if the array is not empty.
            }
            return $dataset->suvisiace_projekty = $output;
        }else
        {
            return $dataset->suvisiace_projekty = null;
        }
    }

    public function getHyperlinkUloziskoProjektu($item, $dataset)
    {
        if (isset($item->PP_DoplnujuceUdaje)) {

            $dataset->hyperlink_na_ulozisko_projektu = $item->PP_DoplnujuceUdaje->hyperlink_na_ulozisko_projektu;
            return $dataset;
        }
        else
        {
            $dataset->hyperlink_na_ulozisko_projektu=null;
            return $dataset;
        }
    }

    public function getNajaktualnejsiaCenaProjektuDPH($item, $dataset)
    {
        if (isset($item->PP_PP_Details)) {

            $dataset->najaktualnejsia_cena_projektu_vrat_DPH = $item->PP_PP_Details->najaktualnejsia_cena_projektu_vrat_DPH;
            return $dataset;
        }
        else
        {
            $dataset->najaktualnejsia_cena_projektu_vrat_DPH=null;
            return $dataset;
        }
    }

    public function getNajaktualRocnePrevadzkoveNakladyProjektuDPH($item, $dataset)
    {
        if (isset($item->PP_PP_Details)) {

            $dataset->najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH = $item->PP_PP_Details->najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH;
            return $dataset;
        }
        else
        {
            $dataset->najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH=null;
            return $dataset;
        }
    }

    public function getMaxRok($item, $dataset)
    {
        $dataset->max_rok=$item->max_rok;
        return $dataset;
    }

    public function getPoznamky($item, $dataset)
    {
        if (isset($item->PP_PP_Details)) {

            $dataset->poznamky = $item->PP_PP_Details->poznamky;
            return $dataset;
        }
        else
        {
            $dataset->poznamky=null;
            return $dataset;
        }
    }


    public function getFilterReporting($item, $dataset)
    {

    }


}

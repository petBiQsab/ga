<?php

namespace App\Http\Repositories;

use App\Http\Factories\StoreDataFactory;
use App\Http\Interface\ProjectDetailInterface;
use App\Models\Akceptacia;
use App\Models\Aktivita_Kategoria;
use App\Models\Aktivity_pp;
use App\Models\Doplnujuce_udaje;
use App\Models\Externe_financovanie;
use App\Models\Faza_projektu;
use App\Models\Hashtag;
use App\Models\Kategoria;
use App\Models\Kvalifikovany_odhad;
use App\Models\Kvalifikovany_odhad_roky;
use App\Models\Mestska_cast;
use App\Models\MTL;
use App\Models\Muscow;
use App\Models\Organizacia_projektu;
use App\Models\Phsr;
use App\Models\Planovanie_rozpoctu;
use App\Models\Politicka_priorita;
use App\Models\Priorita;
use App\Models\Prioritne_oblasti;
use App\Models\Projektova_idea;
use App\Models\Projektova_idea_roky;
use App\Models\Projektove_portfolio;
use App\Models\Projektove_portfolio_details;
use App\Models\Projektovy_zamer;
use App\Models\Projektovy_zamer_roky;
use App\Models\Reporting;
use App\Models\RYG;
use App\Models\Schvalenie_projektu;
use App\Models\Specificke_atributy;
use App\Models\Stav_projektu;
use App\Models\Typ_projektu;
use App\Models\User;
use App\Models\Verejna_praca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;
use function Symfony\Component\String\s;


class ProjectDetailRepository extends DataRepository implements ProjectDetailInterface
{
    private bool $isDirty;

    public function __construct()
    {
        $this->isDirty = false;
    }

    private function saveDirty(bool $changeBool): bool
    {
        if ($changeBool === true) {
            $this->isDirty = true;
        }
        return $this->isDirty;
    }

    public function createDataset($projekt)
    {
        $dataset=new \stdClass();
        $this->getZakladneInformacie($projekt,$dataset);
        $this->getPrepojenieNaBA30($projekt,$dataset);
        $this->getZaradenieProjektu($projekt,$dataset);
        $this->getZivotnyCyklusProjektu($projekt,$dataset);
        $this->getTerminyProjektu($projekt,$dataset);
        $this->getAktivity($projekt,$dataset);
        $this->getOrganizaciaProjektu($projekt,$dataset);
        $this->getSchvalenieProjektu($projekt,$dataset);
        $this->getDoplnujuceUdaje($projekt,$dataset);
        $this->getCelkoveVydavkyProjektu($projekt,$dataset);
        $this->getProjektovaIdea($projekt,$dataset);
        $this->getProjektovyZamer($projekt,$dataset);
        $this->getKvalifikovanyOdhad($projekt,$dataset);
        $this->getInterneUdaje($projekt,$dataset);
        return $dataset;
    }

    public function collectCiselniky()
    {
        $ciselniky=new \stdClass();
        $ciselniky->aktivity =$this->getAktivityCiselnik();
        $ciselniky->aktivity_kategoria=Aktivita_Kategoria::select(['value', 'id'])->orderBy('orderNum')->get();
        $ciselniky->externe_financovanie = Externe_financovanie::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->faza_projektu = Faza_projektu::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->groups=$this->getGroups();
        $ciselniky->organizacie=$this->getOrganizacie();
        $ciselniky->hashtag = Hashtag::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->kategoria = Kategoria::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->mestska_cast = Mestska_cast::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->magistratny_garant=$this->getUsers();
        $ciselniky->mananagers=$this->getManagersCiselnik();
        $ciselniky->planovanie_rozpoctu = Planovanie_rozpoctu::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->politicka_priorita = Politicka_priorita::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->politicky_garant=$this->getUsers();
        $ciselniky->prepojenie_na_ba30 = Phsr::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->prepojenie_na_ba30_strateg_ciel = Phsr::select(['value', 'id'])->where(['type' => "Strategický cieľ"])->orderBy('value')->get();
        $ciselniky->prepojenie_na_ba30_speci_ciel = Phsr::select(['value', 'id'])->where(['type' => "Špecifický cieľ"])->orderBy('value')->get();
        $ciselniky->prepojenie_na_ba30_program = Phsr::select(['value', 'id'])->where(['type' => "Program"])->orderBy('value')->get();
        $ciselniky->priorita = Priorita::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->prioritne_oblasti = Prioritne_oblasti::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->suvisiace_projekty=$this->getSuvisProjektyCiselnik();
        $ciselniky->reporting = Reporting::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->schvaleniePIPZPG = Akceptacia::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->specificke_atributy = Specificke_atributy::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->stav_projektu = Stav_projektu::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->typ_projektu = Typ_projektu::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->users=$this->getUsers();
        $ciselniky->verejna_praca = Verejna_praca::select(['value', 'id'])->orderBy('value')->get();
        $ciselniky->ryg = RYG::select(['value', 'id'])->orderBy('id')->get();
        $ciselniky->muscow = Muscow::select(['value', 'id'])->orderBy('value')->get();

        return $ciselniky;
    }


    public function createEmptyProject()
    {
        $projekt=new Projektove_portfolio();
        $dataset=new \stdClass();

        $this->getZakladneInformacie($projekt,$dataset);
        $this->getPrepojenieNaBA30($projekt,$dataset);
        $this->getZaradenieProjektu($projekt,$dataset);
        $this->getZivotnyCyklusProjektu($projekt,$dataset);
        $this->getTerminyProjektu($projekt,$dataset);
        $this->getAktivity($projekt,$dataset);
        $this->getOrganizaciaProjektu($projekt,$dataset);
        $this->getSchvalenieProjektu($projekt,$dataset);
        $this->getDoplnujuceUdaje($projekt,$dataset);
        $this->getCelkoveVydavkyProjektu($projekt,$dataset);
        $this->getProjektovaIdea($projekt,$dataset);
        $this->getProjektovyZamer($projekt,$dataset);
        $this->getKvalifikovanyOdhad($projekt,$dataset);
        $this->getInterneUdaje($projekt,$dataset);
        return $dataset;
    }

    private function checkProperty($attr,$property)
    {
        if (is_object($attr)==true && isset($attr->type)
            && ($attr->type=="d.m.Y" or $attr->type=="m.Y" or $attr->type=="number") && $attr->value==null)
        {
            $obj=new \stdClass();
            $obj->$property=$attr->$property;
            return $obj;
        }

        if (!isset($attr->$property))
        {
            $obj=new \stdClass();
            $obj->$property=$attr;
            return $obj;
        }else
        {
            $obj=new \stdClass();
            $obj->$property=$attr->$property;
            return $obj;
        }
    }

    private function newProjectInit($zakladne_informacie)
    {
        $projektove_portfolio=new Projektove_portfolio();
        $projektove_portfolio->save();
        $projektove_portfolio->id_original=$projektove_portfolio->id;
        $projektove_portfolio->active_reporting_cycle=1;
        $projektove_portfolio->rgp_ready=0;

        if (isset($zakladne_informacie->id_pp->value))
        {
            $projektove_portfolio->id_projekt=$zakladne_informacie->id_pp->value;
        }
        else
        {
            $projektove_portfolio->id_projekt=$zakladne_informacie->id_pp;
        }

        $projektove_portfolio->save();
        return $projektove_portfolio;
    }

    public function storeEditProject(Request $request)
    {
        $request = json_decode($request->getContent());
        $projektove_portfolio = Projektove_portfolio::where(['id' => $request->zakladne_informacie->id_original])->first();

        if ($projektove_portfolio === null) // ak sa vytvara novy projektu
        {
            $projektove_portfolio = $this->newProjectInit($request->zakladne_informacie);
            $id_original = $projektove_portfolio->id_original;
            $request->aktivity->reset = null;

        } else {
            $id_original = $request->zakladne_informacie->id_original;

            $request->aktivity->reset = null;
        }

        $storeFactory = new StoreDataFactory();

     $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'id_projekt', $id_original, $this->checkProperty($request->zakladne_informacie->id_pp, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'nazov_projektu', $id_original, $this->checkProperty($request->zakladne_informacie->nazov_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'alt_nazov_projektu', $id_original, $this->checkProperty($request->zakladne_informacie->alt_nazov_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'ciel_projektu', $id_original, $this->checkProperty($request->zakladne_informacie->ciel_projektu, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $idPPHSR = array_merge($request->prepojenie_na_ba30->strategicky_ciel_PHSR, $request->prepojenie_na_ba30->specificky_ciel_PHSR, $request->prepojenie_na_ba30->program);
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->PHSR(), $id_original, $idPPHSR));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'meratelny_vystupovy_ukazovatel', $id_original, $this->checkProperty($request->prepojenie_na_ba30->meratelny_vystupovy_ukazovatel, 'value')->value));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->TypProjektu(), $id_original, $request->zaradenie_projektu->typ_projektu));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->PrioritneOblasti(), $id_original, $request->zaradenie_projektu->prioritne_oblasti));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'id_ryg', $id_original, $this->checkProperty($request->zaradenie_projektu->ryg, 'id')->id));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'id_muscow', $id_original, $this->checkProperty($request->zaradenie_projektu->muscow, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'id_kategoria_projektu', $id_original, $this->checkProperty($request->zaradenie_projektu->kategoria, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'id_stav_projektu', $id_original, $this->checkProperty($request->zivotny_cyklus_projektu->stav_projektu, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'id_faza_projektu', $id_original, $this->checkProperty($request->zivotny_cyklus_projektu->faza_projektu, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'datum_zacatia_projektu', $id_original, $this->checkProperty($request->terminy_projektu->datum_zacatia_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'datum_konca_projektu', $id_original, $this->checkProperty($request->terminy_projektu->datum_konca_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'rizika_projektu', $id_original, $this->checkProperty($request->aktivity->rizika_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'zrealizovane_aktivity', $id_original, $this->checkProperty($request->aktivity->zrealizovane_aktivity, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'planovane_aktivity_na_najblizsi_tyzden', $id_original, $this->checkProperty($request->aktivity->planovane_aktivity_na_najblizsi_tyzden, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new MTL(), 'status', $id_original, $this->checkProperty($request->aktivity->mtl, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $store->store(new MTL(), 'reset', $id_original, $this->checkProperty($request->aktivity->reset, 'value')->value);
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new MTL(), 'komentar', $id_original, $this->checkProperty($request->aktivity->komentar, 'value')->value));

        //TODO//////////AKTIVITY///////AKTIVITY//////////AKTIVITY/////////////AKTIVITY///////AKTIVITY///////////
        $store = $storeFactory->inicializeStoring('Aktivity');
        $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(), 'standard', $id_original, $request->aktivity->aktivity_standard));
        $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(), 'vlastna', $id_original, $request->aktivity->aktivity_vlastne));
        //TODO//////////AKTIVITY///////AKTIVITY//////////AKTIVITY/////////////AKTIVITY///////AKTIVITY///////////


        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Organizacia_projektu(), 'id_zadavatel_projektu', $id_original, $this->checkProperty($request->organizacia_projektu->zadavatel_projektu, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Organizacia_projektu(), 'id_projektovy_garant', $id_original, $this->checkProperty($request->organizacia_projektu->projektovy_garant, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Organizacia_projektu(), 'id_politicky_garant', $id_original, $this->checkProperty($request->organizacia_projektu->politicky_garant, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Organizacia_projektu(), 'id_magistratny_garant', $id_original, $this->checkProperty($request->organizacia_projektu->magistratny_garant, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Organizacia_projektu(), 'externi_stakeholderi', $id_original, $this->checkProperty($request->organizacia_projektu->externi_stakeholderi, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->ProjektovyManager(), $id_original, $request->organizacia_projektu->projektovy_manager));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->CoopUtvary(), $id_original, $request->organizacia_projektu->coop_utvary));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->CoopOrganizacie(), $id_original, $request->organizacia_projektu->coop_organizacie));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->Sprava(), $id_original, $request->organizacia_projektu->sprava));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->Udrzba(), $id_original, $request->organizacia_projektu->udrzba));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->RiadiaceGremium(), $id_original, $request->organizacia_projektu->riadiace_gremium));
        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->ProjektovyTim(), $id_original, $request->organizacia_projektu->projektovy_tim));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'datum_schvalenia_ID', $id_original, $this->checkProperty($request->schvalenie_projektu->datum_schvalenie_id, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'id_schvalenie_pi_na_pg', $id_original, $this->checkProperty($request->schvalenie_projektu->schvalenie_pi_na_pg, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'datum_schvalenia_pi_na_pg', $id_original, $this->checkProperty($request->schvalenie_projektu->datum_schvalenia_pi_na_pg, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'hyperlink_na_pi', $id_original, $this->checkProperty($request->schvalenie_projektu->hyperlink_na_pi, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'pripomienky_k_pi', $id_original, $this->checkProperty($request->schvalenie_projektu->pripomienky_k_pi, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'id_schvalenie_pz_na_pg', $id_original, $this->checkProperty($request->schvalenie_projektu->schvalenie_pz_na_pg, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'datum_schvalenia_pz_na_pg', $id_original, $this->checkProperty($request->schvalenie_projektu->datum_schvalenia_pz_na_pg, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'hyperlink_na_pz', $id_original, $this->checkProperty($request->schvalenie_projektu->hyperlink_na_pz, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'pripomienky_k_pz', $id_original, $this->checkProperty($request->schvalenie_projektu->pripomienky_k_pz, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'datum_schvalenia_projektu_ppp', $id_original, $this->checkProperty($request->schvalenie_projektu->datum_schvalenia_projektu_ppp, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Schvalenie_projektu(), 'datum_schvalenia_projektu_msz', $id_original, $this->checkProperty($request->schvalenie_projektu->datum_schvalenia_projektu_msz, 'value')->value));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'id_externe_financovanie', $id_original, $this->checkProperty($request->doplnujuce_udaje->externe_financovanie, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'zdroj_externeho_financovania', $id_original, $this->checkProperty($request->doplnujuce_udaje->zdroj_externeho_financovania, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'suma_externeho_financovania', $id_original, $this->checkProperty($request->doplnujuce_udaje->suma_externeho_financovania, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'podiel_externeho_financovania_z_celkovej_ceny', $id_original, $this->checkProperty($request->doplnujuce_udaje->podiel_externeho_financovania_z_celkovej_ceny, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->MestskaCast(), $id_original, $request->doplnujuce_udaje->mestska_cast));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'id_priorita', $id_original, $this->checkProperty($request->doplnujuce_udaje->id_priorita, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'id_priorita_new', $id_original, $this->checkProperty($request->doplnujuce_udaje->id_priorita_new, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'id_verejna_praca', $id_original, $this->checkProperty($request->doplnujuce_udaje->verejna_praca, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Doplnujuce_udaje(), 'hyperlink_na_ulozisko_projektu', $id_original, $this->checkProperty($request->doplnujuce_udaje->hyperlink_na_ulozisko_projektu, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjects');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), $projektove_portfolio->SuvisiaceProjekty(), $id_original, $request->doplnujuce_udaje->suvisiace_projekty));

        $store = $storeFactory->inicializeStoring('Tags');
        $this->isDirty = $this->saveDirty($store->store($projektove_portfolio->Hashtag(), new Hashtag(), $id_original, $request->doplnujuce_udaje->hashtag));
        $store = $storeFactory->inicializeStoring('Tags');
        $this->isDirty = $this->saveDirty($store->store($projektove_portfolio->SpeciAtribut(), new Specificke_atributy(), $id_original, $request->doplnujuce_udaje->specificke_atributy));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'najaktualnejsia_cena_projektu_vrat_DPH', $id_original, $this->checkProperty($request->celkove_vydavky_projektu->najaktualnejsia_cena_projektu_vrat_DPH, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH', $id_original, $this->checkProperty($request->celkove_vydavky_projektu->najaktual_rocne_prevadzkove_naklady_projektu_vrat_DPH, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea(), 'celkom_bv_a_kv_vrat_dph', $id_original, $this->checkProperty($request->projektova_idea->celkom_bv_a_kv_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea(), 'rocne_prevadzkove_naklady_projektu_vrat_dph', $id_original, $this->checkProperty($request->projektova_idea->rocne_prevadzkove_naklady_projektu_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea(), 'idea_bezne_ocakavane_rocne_naklady_projektu_s_dph', $id_original, $this->checkProperty($request->projektova_idea->idea_bezne_ocakavane_rocne_naklady_projektu_s_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea(), 'idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph', $id_original, $this->checkProperty($request->projektova_idea->idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        // dd($request->projektova_idea->projektova_idea_roky->bv);
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea_roky(), ['typ' => 'BV'], $id_original, $request->projektova_idea->projektova_idea_roky->bv));
        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Projektova_idea_roky(), ['typ' => 'KV'], $id_original, $request->projektova_idea->projektova_idea_roky->kv));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'celkom_vrat_dph', $id_original, $this->checkProperty($request->projektovy_zamer->celkom_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'rocne_prevadzkove_naklady_vrat_dph', $id_original, $this->checkProperty($request->projektovy_zamer->rocne_prevadzkove_naklady_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph', $id_original, $this->checkProperty($request->projektovy_zamer->zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph', $id_original, $this->checkProperty($request->projektovy_zamer->zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'bezne_prijmy_celkom_vrat_dph', $id_original, $this->checkProperty($request->projektovy_zamer->bezne_prijmy_celkom_vrat_dph, 'value')->value));

        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer(), 'kapitalove_prijmy_celkom_vrat_dph', $id_original, $this->checkProperty($request->projektovy_zamer->kapitalove_prijmy_celkom_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer_roky(), ['typ' => 'BV'], $id_original, $request->projektovy_zamer->projektovy_zamer_roky->bv));
        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer_roky(), ['typ' => 'KV'], $id_original, $request->projektovy_zamer->projektovy_zamer_roky->kv));
        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer_roky(), ['typ' => 'BP'], $id_original, $request->projektovy_zamer->projektovy_zamer_roky->bp));
        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Projektovy_zamer_roky(), ['typ' => 'KP'], $id_original, $request->projektovy_zamer->projektovy_zamer_roky->kp));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Kvalifikovany_odhad(), 'kvalifikovany_odhad_ceny_projektu', $id_original, $this->checkProperty($request->kvalifikovany_odhad->kvalifikovany_odhad_ceny_projektu, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Kvalifikovany_odhad(), 'kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph', $id_original, $this->checkProperty($request->kvalifikovany_odhad->kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Kvalifikovany_odhad(), 'zdroj_info_kvalif_odhad', $id_original, $this->checkProperty($request->kvalifikovany_odhad->zdroj_info_kvalif_odhad, 'value')->value));

        $store = $storeFactory->inicializeStoring('ArrObjectsRoky');
        $this->isDirty = $this->saveDirty($store->store(new Kvalifikovany_odhad_roky(), ['typ' => 'none'], $id_original, $request->kvalifikovany_odhad->kvalifikovany_odhad_roky->roky));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'id_reporting', $id_original, $this->checkProperty($request->interne_udaje->reporting, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'id_planovanie_rozpoctu', $id_original, $this->checkProperty($request->interne_udaje->planovanie_rozpoctu, 'id')->id));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'max_rok', $id_original, $this->checkProperty($request->interne_udaje->max_rok, 'value')->value));
        $store = $storeFactory->inicializeStoring('value');
        $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'poznamky', $id_original, $this->checkProperty($request->interne_udaje->poznamky, 'value')->value));

        $storeFactory = new StoreDataFactory();
        if (auth()->user()!==null && $this->isDirty === true) {
            $store = $storeFactory->inicializeStoring('value');
            $store->store(new Projektove_portfolio(), 'updated_by', $id_original, auth()->user()->objectguid);

            $store = $storeFactory->inicializeStoring('value');
            $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio(), 'updated_at', $id_original, Carbon::now()->setTimezone('Europe/Bratislava')));
            $store = $storeFactory->inicializeStoring('value');
            $this->isDirty = $this->saveDirty($store->store(new Projektove_portfolio_details(), 'updated_at', $id_original, $this->checkProperty($request->zakladne_informacie->updated_at, 'value')->value));
        }

        $returnData = new stdClass();
        $returnData->id = $projektove_portfolio->id;
        $returnData->statusCode = $this->isDirtyStatusCode($this->isDirty);
        return $returnData;

    }

    private function isDirtyStatusCode(bool $isDirty): int
    {
        if ($isDirty)
        {
            return 201;
        }
        return 202;
    }

    public function deleteProject($id)
    {
        $projekt=Projektove_portfolio::where(['id'=>$id])->first();

        if ($projekt!=null)
        {
            return $projekt->delete();
        }
        return null;

    }

    public function rgbWorkflow()
    {

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function pracovisko()
    {
        $dataset=[];
        for ($i=0;$i<34;$i++)
        {
            $datasetItem=new \stdClass();
            $datasetItem->id=$i+1;
            $datasetItem->mtl="green";
            $datasetItem->atl="red";
            $datasetItem->nazov_projektu="Centrálne námestie Devínska Nová Ves";
            $datasetItem->alt_nazov_projektu="Centrálne námestie v mestskej časti Devínska Nová Ves";
            $datasetItem->ciel_projektu="Má slúžiť na celoročné kultúrno – spoločenské aktivity, má dopĺňať občianku vybavenosť a parkovací dom má v MČ pomôcť riešiť parkovaciu politiku";
            $datasetItem->strategicky_ciel_PHSR=["C2.2. Mesto, ktoré ponúka kvalitnú kultúru a udržateľné susedstvá"];
            $datasetItem->specificky_ciel_PHSR=["C2.2.1. Živý verejný priestor a susedstvá"];
            $datasetItem->program=["C2.2.1.P Revitalizácia a rozvoj verejných priestorov"];
            $datasetItem->meratelny_vystupovy_ukazovatel=null;
            $datasetItem->typ_projektu=["Verejné priestory1"];
            $datasetItem->kategoria_projektu="A";
            $datasetItem->prioritne_oblasti=["Klimaticky odolné a zdravé mesto", "Bezpečná a udržateľná mestská mobilita"];
            $datasetItem->planovanie_rozpoctu="Nie";
            $datasetItem->datum_zacatia_projektu="2022-11-01";
            $datasetItem->datum_konca_projektu="2023-1-01";
            $datasetItem->stav_projektu="Projekt zastavený";
            $datasetItem->faza_projektu="Príprava projektového zámeru";
            $datasetItem->posledna_ukoncena_aktivita="Participácia";
            $datasetItem->zadavatel_projektu="Metropolitný inštitút Bratislavy";
            $datasetItem->projektovy_garant="Tóthová Zuzana, Mgr.";
            $datasetItem->utvar_projektoveho_manazera=["Metropolitný inštitút Bratislavy"];
            $datasetItem->projektovy_manazer=["Tóthová Zuzana, Mgr."];
            $datasetItem->coop_utvary=['SV', 'OP', 'OVO', 'SŽP', 'SV'];
            $datasetItem->coop_organizacie=['MIB'];
            $datasetItem->projektovy_tim=["Puschmannová Natália, Ing. arch.", "Blažo Richard, Ing. arch"];
            $datasetItem->riadiace_gremium=[];
            $datasetItem->datum_schvalenie_pi_na_pg="2022-2-08";
            $datasetItem->datum_schvalenie_pz_na_pg="2022-8-10";
            $datasetItem->suma_externeho_financovania="200000.2";
            $datasetItem->zdroj_externeho_financovania="fondy";
            $datasetItem->mestska_cast=["Devínska Nová Ves"];
            $datasetItem->priorita="***";
            $datasetItem->specificke_atributy=["atribut", "atribut2"];
            $datasetItem->hashtagy=["#hashtag","#hashtag2"];
            $datasetItem->reporting=2;
            $dataset[]=$datasetItem;

            $datasetItem=new \stdClass();
            $datasetItem->id=$i+2;
            $datasetItem->mtl="orange";
            $datasetItem->atl="green";
            $datasetItem->nazov_projektu="Revitalizácia Železnej studničky (Promenáda Železná studnička)";
            $datasetItem->alt_nazov_projektu="Železná studnička - predĺženie promenády - komplexná rekonštrukcia komunikácie, Železná studnička - pozemné stavby PD+R (1. a 2. rybník od lanovky smerom dole), Komplexná revitalizácia futbalového ihriska na Železnej studničke, Revitalizácia a zlepšenie rekreačnej infraštruktúry v okolí rybníkov na železnej studničke";
            $datasetItem->ciel_projektu="Predĺženie promenády - rekonštrukcia spevnených plôch, odvodnenie komunikácie, predĺženie verejného osvetlenia, rekonštrukcia zábradlia pozdĺž pomunikácie, návrh trvalého opatrenia pre ochranu miestnych obojživeľníkov";
            $datasetItem->strategicky_ciel_PHSR=["C2.2. Mesto, ktoré ponúka kvalitnú kultúru a udržateľné susedstvá"];
            $datasetItem->specificky_ciel_PHSR=["C2.2.1. Živý verejný priestor a susedstvá"];
            $datasetItem->program=["C2.2.1.P Program tvorby a revitalizácie verejných parkov v meste"];
            $datasetItem->meratelny_vystupovy_ukazovatel=null;
            $datasetItem->typ_projektu=["Verejné priestory2"];
            $datasetItem->kategoria_projektu="(B)";
            $datasetItem->prioritne_oblasti=["Klimaticky odolné a zdravé mesto"];
            $datasetItem->planovanie_rozpoctu="Áno";
            $datasetItem->datum_zacatia_projektu="2022-2-08";
            $datasetItem->datum_konca_projektu="2022-2-08";
            $datasetItem->stav_projektu="Projektový zámer schválený";
            $datasetItem->faza_projektu="Plánovanie a realizácia projektu";
            $datasetItem->posledna_ukoncena_aktivita="Architektonická štúdia";
            $datasetItem->zadavatel_projektu="Sekcia výstavby";
            $datasetItem->projektovy_garant="Lukáš Dinda";
            $datasetItem->utvar_projektoveho_manazera=["Sekcia výstavby"];
            $datasetItem->projektovy_manazer=["Hutníková Ivana, Ing."];
            $datasetItem->coop_utvary=["SV"];
            $datasetItem->coop_organizacie=['MLB'];
            $datasetItem->projektovy_tim=["Dzurilla Marcel"];
            $datasetItem->riadiace_gremium=[];
            $datasetItem->datum_schvalenie_pi_na_pg="2023-5-03";
            $datasetItem->datum_schvalenie_pz_na_pg="2022-10-05";
            $datasetItem->suma_externeho_financovania="0";
            $datasetItem->zdroj_externeho_financovania="ÚMR (2.7.4) (pod)";
            $datasetItem->mestska_cast=["Nové Mesto"];
            $datasetItem->priorita="**";
            $datasetItem->specificke_atributy=[];
            $datasetItem->hashtagy=[];
            $datasetItem->reporting=0;
            $dataset[]=$datasetItem;

            $datasetItem=new \stdClass();
            $datasetItem->id=$i+3;
            $datasetItem->mtl="green";
            $datasetItem->atl="green";
            $datasetItem->nazov_projektu="Pekná cesta - Revitalizácia areálu muničných skladov";
            $datasetItem->alt_nazov_projektu="Revitalizácia areálu muničného skladu a okolie, Multifunkčné ihrisko v areáli bývalých muničných skladov v Rači";
            $datasetItem->ciel_projektu="Revitalizácia / Úprava objektu starej hájovne a priľahlého okolia -objektu okolia-nový altánok, výsadba, povrchy, mobiliár, osvetlenie";
            $datasetItem->strategicky_ciel_PHSR=["C2.2. Mesto, ktoré ponúka kvalitnú kultúru a udržateľné susedstvá","C2.3. Zelené a zdravé mesto"];
            $datasetItem->specificky_ciel_PHSR=["C2.2.1. Živý verejný priestor a susedstvá","C2.3.2. Možnosti pre pohyb, rekreáciu a zdravý životný štýl"];
            $datasetItem->program=["C2.2.1.P Revitalizácia a rozvoj verejných priestorov","C2.3.2.P Program rozvoja a zvyšovania dostupnosti športovej infraštruktúry"];
            $datasetItem->meratelny_vystupovy_ukazovatel="7 cvičiacich zón";
            $datasetItem->typ_projektu=["Verejné priestory"];
            $datasetItem->kategoria_projektu="(B)";
            $datasetItem->prioritne_oblasti=[];
            $datasetItem->planovanie_rozpoctu="Nie";
            $datasetItem->datum_zacatia_projektu="2022-10-05";
            $datasetItem->datum_konca_projektu="2022-10-05";
            $datasetItem->stav_projektu="Projektový zámer schválený";
            $datasetItem->faza_projektu="Plánovanie a realizácia projektu";
            $datasetItem->posledna_ukoncena_aktivita=null;
            $datasetItem->zadavatel_projektu=null;
            $datasetItem->projektovy_garant=null;
            $datasetItem->utvar_projektoveho_manazera=[];
            $datasetItem->projektovy_manazer=[];
            $datasetItem->coop_utvary=["SŽP", "SV", "ÚSMP"];
            $datasetItem->coop_organizacie=["MLB", "MIB"];
            $datasetItem->projektovy_tim=[];
            $datasetItem->riadiace_gremium=[];
            $datasetItem->datum_schvalenie_pi_na_pg=null;
            $datasetItem->datum_schvalenie_pz_na_pg=null;
            $datasetItem->suma_externeho_financovania=0;
            $datasetItem->zdroj_externeho_financovania=null;
            $datasetItem->mestska_cast=["Rača"];
            $datasetItem->priorita=null;
            $datasetItem->specificke_atributy=["atribut_test", "atribut2_test"];
            $datasetItem->hashtagy=["#hashtag","#hashtag_test"];
            $datasetItem->reporting=1;
            $dataset[]=$datasetItem;
        }

        $userInfoData=new \stdClass();
        $userInfoData->moje_utvary_filter2=["Sekcia výstavby"];


        return view('pracovisko')->with('dataset',$dataset)->with('userInfoData',$userInfoData);
    }

    public function project_detail()
    {
        $obj=new \stdClass();

        $zakladne_informacie=new \stdClass();
        $zakladne_informacie->id_pp=1;
        $zakladne_informacie->id_original=1;
        $zakladne_informacie->id_parent=1;
        $zakladne_informacie->id_child=1;
        $zakladne_informacie->nazov_projektu="Testovací dummy projekt";
        $zakladne_informacie->alt_nazov_projektu="Alternativny nazov projektu";
        $obj->zakladne_informacie=$zakladne_informacie;

        $phsr=new \stdClass();
        $phsr->strateg_ciel=[];
        $phsr->speci_ciel=[];
        $phsr->program=[];
        $phsr->meratelny_vystupovy_ukazovatel="meratelny_vystupovy_ukazovatel";

        $phsr_obj1=new \stdClass();
        $phsr_obj1->id=1;
        $phsr_obj1->value="strategicky_ciel1";
        $phsr->strateg_ciel[]=$phsr_obj1;

        $phsr_obj2=new \stdClass();
        $phsr_obj2->id=2;
        $phsr_obj2->value="strategicky_ciel2";
        $phsr->strateg_ciel[]=$phsr_obj2;

        $phsr_obj3=new \stdClass();
        $phsr_obj3->id=3;
        $phsr_obj3->value="specificky_ciel1";
        $phsr->speci_ciel[]=$phsr_obj3;

        $phsr_obj4=new \stdClass();
        $phsr_obj4->id=4;
        $phsr_obj4->value="program1";
        $phsr->program[]=$phsr_obj4;

        $obj->prepojenie_na_ba30=$phsr;

        $zaradenie_projektu=new \stdClass();

        $typ_projektu=[];
        $typ_projektu_obj1=new \stdClass();
        $typ_projektu_obj1->id=1;
        $typ_projektu_obj1->value="Typ projektu1";
        $typ_projektu[]=$typ_projektu_obj1;

        $typ_projektu_obj2=new \stdClass();
        $typ_projektu_obj2->id=2;
        $typ_projektu_obj2->value="Typ projektu2";
        $typ_projektu[]=$typ_projektu_obj2;
        $zaradenie_projektu->typ_projektu=$typ_projektu;

        $kategoria=new \stdClass();
        $kategoria->id=4;
        $kategoria->value="A+";
        $zaradenie_projektu->kategoria=$kategoria;

        $prioritne_oblasti=[];
        $prioritne_oblasti_obj=new \stdClass();
        $prioritne_oblasti_obj->id=2;
        $prioritne_oblasti_obj->value="Klimaticky odolné a zdravé mesto";
        $prioritne_oblasti[]=$prioritne_oblasti_obj;
        $prioritne_oblasti_obj=new \stdClass();
        $prioritne_oblasti_obj->id=3;
        $prioritne_oblasti_obj->value="Bezpečná a udržateľná mestská mobilita";
        $prioritne_oblasti[]=$prioritne_oblasti_obj;
        $zaradenie_projektu->prioritne_oblasti=$prioritne_oblasti;

        $obj->zaradenie_projektu=$zaradenie_projektu;

        $zivotny_cyklus_projektu=new \stdClass();

        $stav_projektu=new \stdClass();
        $stav_projektu->id=1;
        $stav_projektu->value="Stav projektu";
        $zivotny_cyklus_projektu->stav_projektu=$stav_projektu;

        $faza_projektu=new \stdClass();
        $faza_projektu->id=3;
        $faza_projektu->value="Faza projektu";
        $zivotny_cyklus_projektu->faza_projektu=$faza_projektu;

        $obj->zivotny_cyklus_projektu=$zivotny_cyklus_projektu;

        $terminy_projektu=new \stdClass();
        $terminy_projektu->datum_zacatia_projektu="2022-10-05";
        $terminy_projektu->datum_konca_projektu="2033-10-05";
        $obj->terminy_projektu=$terminy_projektu;

        $aktivity=new \stdClass();
        $aktivity_standard=[];
        $aktivity_vlastne=[];

        $aktivity_obj1=new \stdClass();
        $aktivity_obj1->id_aktivita=null;
        $aktivity_obj1->value=null;
        $zodpovedni=[];
        $aktivity_obj1->zodpovedne_osoby=$zodpovedni;
        $aktivity_obj1->vlastna_aktivita="Text vlastnej aktivity";
        $aktivity_obj1->zaciatok_aktivity="2024-11-23";
        $aktivity_obj1->realny_zaciatok_aktivity="2024-11-23";
        $aktivity_obj1->koniec_aktivity="2029-12-23";
        $aktivity_obj1->realny_koniec_aktivity="2029-12-23";
        $aktivity_vlastne[]=$aktivity_obj1;

        $aktivity_obj2=new \stdClass();
        $aktivity_obj2->id_aktivita=1;
        $aktivity_obj2->value="Aktivita standardna1";
        $zodpovedni=[];
        $zodpovedny=new \stdClass();
        $zodpovedny->id="fdasfasd-dfadfa";
        $zodpovedny->value="Janko Hrasko";
        $zodpovedni[]=$zodpovedny;
        $aktivity_obj2->zodpovedne_osoby=$zodpovedni;
        $aktivity_obj2->vlastna_aktivita=null;
        $aktivity_obj2->zaciatok_aktivity="2022-11-23";
        $aktivity_obj2->realny_zaciatok_aktivity=null;
        $aktivity_obj2->koniec_aktivity="2025-12-23";
        $aktivity_obj2->realny_koniec_aktivity="2029-12-23";
        $aktivity_standard[]=$aktivity_obj2;

        $aktivity_obj3=new \stdClass();
        $aktivity_obj3->id_aktivita=2;
        $aktivity_obj3->value="Aktivita standardna2";
        $zodpovedni=[];
        $aktivity_obj3->zodpovedne_osoby=$zodpovedni;
        $aktivity_obj3->vlastna_aktivita=null;
        $aktivity_obj3->zaciatok_aktivity="2022-11-23";
        $aktivity_obj3->realny_zaciatok_aktivity="2024-11-23";
        $aktivity_obj3->koniec_aktivity="2025-12-23";
        $aktivity_obj3->realny_koniec_aktivity=null;
        $aktivity_standard[]=$aktivity_obj3;

        $aktivity_obj4=new \stdClass();
        $aktivity_obj4->id_aktivita=null;
        $aktivity_obj4->value=null;
        $zodpovedni=[];
        $zodpovedny=new \stdClass();
        $zodpovedny->id="fdasfasd-dfadfa";
        $zodpovedny->value="Janko Hrasko";
        $zodpovedni[]=$zodpovedny;
        $zodpovedny=new \stdClass();
        $zodpovedny->id="prwsfasd-dfadfdsa";
        $zodpovedny->value="Jožko Mrkvička";
        $zodpovedni[]=$zodpovedny;
        $aktivity_obj4->zodpovedne_osoby=$zodpovedni;
        $aktivity_obj4->vlastna_aktivita="Text vlastnej aktivity 2";
        $aktivity_obj4->zaciatok_aktivity="2026-11-23";
        $aktivity_obj4->potvrdenie_zacatia_aktivity=0;
        $aktivity_obj4->koniec_aktivity="2029-12-23";
        $aktivity_obj4->potvrdenie_konca_aktivity=0;
        $aktivity_vlastne[]=$aktivity_obj4;

        $aktivity->mtl="orange";
        $aktivity->komentar="komentar";
        $aktivity->standard=$aktivity_standard;
        $aktivity->vlastne=$aktivity_vlastne;

        $aktivity->rizika_projektu=" Stavebné povolenie môže byť zdržané úradným konaním
 Financovanie z OPII do konca 2023
 Potreba MPV pre inžinierske siete v koridore trate";
        $aktivity->zrealizovane_aktivity=" oslovenie a zber vyjadrení správcov a organizácii k plánovanej činnosti
 MPV chýbajúcich pozemkov (UNB, MINV, ...) - príprava podkladov do zastupiteľstva
 podanie žiadostí o stavebné povolenie
 finalizácia podkladov k vyhláseniu VO na SD";
        $aktivity->planovane_aktivity_na_najblizsi_tyzden=" Schválenie DSP dokumentacie
 oslovenie a zber vyjadrení správcov a organizácii k plánovanej činnosti
 Oslovenie majiteľov pozemkov zasiahnutých stavbou - zostava cca 15 majiteľov";

        $obj->aktivity=$aktivity;

        $organizacia_projektu=new \stdClass();

        $zadavatel_projektu=new \stdClass();
        $zadavatel_projektu->id="32-a";
        $zadavatel_projektu->value="Oddelenie aplikačnej podpory";
        $organizacia_projektu->zadavatel_projektu=$zadavatel_projektu;

        $projektovy_garant=new \stdClass();
        $projektovy_garant->id="11c";
        $projektovy_garant->value="Janko Mrkvička";
        $organizacia_projektu->projektovy_garant=$projektovy_garant;

        $utvar_projektoveho_managera=new \stdClass();
        $utvar_projektoveho_managera->id="12d";
        $utvar_projektoveho_managera->value="Oddelenie projektoveho managera";
        $organizacia_projektu->utvar_projektoveho_managera=$utvar_projektoveho_managera;


        $projektovy_manager=[];
        $projektovy_manager_obj1=new \stdClass();
        $projektovy_manager_obj1->id="dsfa_1";
        $projektovy_manager_obj1->value="Meno priezisko1";

        $projektovy_manager_obj2=new \stdClass();
        $projektovy_manager_obj2->id="dsfa_2";
        $projektovy_manager_obj2->value="Meno priezisko2";
        $organizacia_projektu->projektovy_manager=$projektovy_manager;

        $coop_utvary=[];
        $coop_utvary_obj=new \stdClass();
        $coop_utvary_obj->id="23edwf";
        $coop_utvary_obj->value="Spolupracujuci utvar/organizacia1";
        $coop_utvary[]=$coop_utvary_obj;

        $coop_utvary_obj2=new \stdClass();
        $coop_utvary_obj2->id="43edwf";
        $coop_utvary_obj2->value="Spolupracujuci utvar/organizacia2";
        $coop_utvary[]=$coop_utvary_obj2;

        $organizacia_projektu->coop_utvary=$coop_utvary;

        $coop_organizacie=[];
        $coop_organizacie_obj=new \stdClass();
        $coop_organizacie_obj->id="23edwf";
        $coop_organizacie_obj->value="Spolupracujuci utvar/organizacia1";
        $coop_organizacie[]=$coop_organizacie_obj;

        $organizacia_projektu->coop_organizacie=$coop_organizacie;
        $organizacia_projektu->externi_stakeholderi="externi stakeholder";


        $riadiace_gremium=[];
        $riadiace_gremium_obj=new \stdClass();
        $riadiace_gremium_obj->id="32sda";
        $riadiace_gremium_obj->value="Meno priezvisko1";
        $riadiace_gremium[]=$riadiace_gremium_obj;
        $organizacia_projektu->riadiace_gremium=$riadiace_gremium;

        $projektovy_tim=[];
        $projektovy_tim_obj=new \stdClass();
        $projektovy_tim_obj->id="dd32";
        $projektovy_tim_obj->value="Meno priezvisko";
        $projektovy_tim[]=$projektovy_tim_obj;

        $projektovy_tim_obj2=new \stdClass();
        $projektovy_tim_obj2->id="dd31";
        $projektovy_tim_obj2->value="Meno priezvisko2";
        $projektovy_tim[]=$projektovy_tim_obj2;

        $organizacia_projektu->projektovy_tim=$projektovy_tim;
        $obj->organizacia_projektu=$organizacia_projektu;

        $schvalenie_projektu=new \stdClass();
        $schvalenie_projektu->datum_schvalenie_id="2023-10-05";

        $schvalenie_pi_na_pg=new \stdClass();
        $schvalenie_pi_na_pg->id=2;
        $schvalenie_pi_na_pg->value="Áno";
        $schvalenie_projektu->schvalenie_pi_na_pg=$schvalenie_pi_na_pg;

        $schvalenie_projektu->datum_schvalenia_pi_na_pg="2023-10-23";
        $schvalenie_projektu->hyperlink_na_pi="https://www.google.com";
        $schvalenie_projektu->pripomienky_k_pi="pripomienky k pi";

        $schvalenie_pz_na_pg=new \stdClass();
        $schvalenie_pz_na_pg->id=1;
        $schvalenie_pz_na_pg->value="Nie";
        $schvalenie_projektu->schvalenie_pz_na_pg=$schvalenie_pz_na_pg;

        $schvalenie_projektu->datum_schvalenia_pz_na_pg="2024-11-23";
        $schvalenie_projektu->hyperlink_na_pz="https://www.google.com";
        $schvalenie_projektu->pripomienky_k_pz="pripomienky k pz";

        $schvalenie_projektu->datum_schvalenia_projektu_ppp="2022-12-23";
        $schvalenie_projektu->datum_schvalenia_projektu_msz="2021-10-13";

        $obj->schvalenie_projektu=$schvalenie_projektu;

        $doplnujuce_udaje=new \stdClass();

        $externe_financovanie=new \stdClass();
        $externe_financovanie->id=1;
        $externe_financovanie->value="EU";

        $doplnujuce_udaje->externe_financovanie=$externe_financovanie;
        $doplnujuce_udaje->zdroj_externeho_financovania="Zdroj externeho financovania";
        $doplnujuce_udaje->zdroj_externeho_financovania="Zdroj externeho financovania";
        $doplnujuce_udaje->suma_externeho_financovania="12345678";
        $doplnujuce_udaje->podiel_externeho_financovania_z_celkovej_ceny=50;

        $mestska_cast=[];
        $mestska_cast_obj1=new \stdClass();
        $mestska_cast_obj1->id=1;
        $mestska_cast_obj1->value="Petržalka";
        $mestska_cast[]=$mestska_cast_obj1;

        $mestska_cast_obj2=new \stdClass();
        $mestska_cast_obj2->id=1;
        $mestska_cast_obj2->value="Ružinov";
        $mestska_cast[]=$mestska_cast_obj2;

        $doplnujuce_udaje->mestska_cast=$mestska_cast;

        $politicka_priorita_obj=new \stdClass();
        $politicka_priorita_obj->id=1;
        $politicka_priorita_obj->value="Politicka priorita";
        $doplnujuce_udaje->id_priorita=$politicka_priorita_obj;

        $politicka_priorita_new_obj=new \stdClass();
        $politicka_priorita_new_obj->id=1;
        $politicka_priorita_new_obj->value="***";
        $doplnujuce_udaje->id_priorita_new=$politicka_priorita_new_obj;

        $verejna_praca_obj=new \stdClass();
        $verejna_praca_obj->id=1;
        $verejna_praca_obj->value="verejna praca";
        $doplnujuce_udaje->verejna_praca=$verejna_praca_obj;
        $doplnujuce_udaje->suvisiace_projekty=[];

        $hashtag=[];
        $hashtag_obj1=new \stdClass();
        $hashtag_obj1->id=1;
        $hashtag_obj1->value="#hashtag";
        $hashtag[]=$hashtag_obj1;

        $hashtag_obj2=new \stdClass();
        $hashtag_obj2->id=1;
        $hashtag_obj2->value="#hashtag";
        $hashtag[]=$hashtag_obj2;

        $doplnujuce_udaje->hashtag=$hashtag;

        $speci_atribut=[];
        $speci_atribut_obj1=new \stdClass();
        $speci_atribut_obj1->id=1;
        $speci_atribut_obj1->value="#speciAtribut";
        $speci_atribut[]=$speci_atribut_obj1;

        $speci_atribut_obj2=new \stdClass();
        $speci_atribut_obj2->id=1;
        $speci_atribut_obj2->value="#SpeciAtribut2";
        $speci_atribut[]=$speci_atribut_obj2;

        $doplnujuce_udaje->specificke_atributy=$speci_atribut;
        $doplnujuce_udaje->hyperlink_na_ulozisko_projektu="https://www.google.com";
        $obj->doplnujuce_udaje=$doplnujuce_udaje;

        $celkove_vydavky_projektu=new \stdClass();
        $celkove_vydavky_projektu->najaktualnejsia_cena_projektu_vrat_DPH=123456789.12;
        $celkove_vydavky_projektu->najaktual_rocne_prevadzkove_naklady_projektu_vrat_DPH=345673.43;
        $obj->celkove_vydavky_projektu=$celkove_vydavky_projektu;



        $projektova_idea=new \stdClass();
        $projektova_idea->celkom_bv_a_kv_vrat_dph=50000000;
        $projektova_idea->rocne_prevadzkove_naklady_projektu_vrat_dph=5000000;
        $projektova_idea->idea_bezne_ocakavane_rocne_naklady_projektu_s_dph=1000000;
        $projektova_idea->idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph=1000000;

        $projektova_idea_roky=new \stdClass();

        $projektova_idea_roky->bv=[];
        $projektova_idea_roky->kv=[];
        for ($i=2022;$i<2034;$i++)
        {
            $projektova_idea_bv=new \stdClass();

            $projektova_idea_bv->id=$i;
            $projektova_idea_bv->value=$i-1427;
            $projektova_idea_roky->bv[]=$projektova_idea_bv;
        }
        for ($i=2022;$i<2034;$i++)
        {
            $projektova_idea_kv=new \stdClass();

            $projektova_idea_kv->id=$i;
            $projektova_idea_kv->value=$i-227;
            $projektova_idea_roky->kv[]=$projektova_idea_kv;
        }
       $projektova_idea->projektova_idea_roky=$projektova_idea_roky;

        $obj->projektova_idea=$projektova_idea;

        $projektovy_zamer=new \stdClass();
        $projektovy_zamer->celkom_vrat_dph=50000000;
        $projektovy_zamer->rocne_prevadzkove_naklady_vrat_dph=5000000;
        $projektovy_zamer->zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph=1000000;
        $projektovy_zamer->zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph=1000000;
        $projektovy_zamer->bezne_prijmy_celkom_vrat_dph=50000000;
        $projektovy_zamer->kapitalove_prijmy_celkom_vrat_dph=5000000;

        $projektovy_zamer_roky=new \stdClass();
        $projektovy_zamer_roky->bv=[];
        $projektovy_zamer_roky->kv=[];
        $projektovy_zamer_roky->bp=[];
        $projektovy_zamer_roky->kp=[];
        for ($i=2022;$i<2034;$i++)
        {
            $projektovy_zamer_bv=new \stdClass();

            $projektovy_zamer_bv->id=$i;
            $projektovy_zamer_bv->value=$i-1117;
            $projektovy_zamer_roky->bv[]=$projektovy_zamer_bv;
        }
        for ($i=2022;$i<2034;$i++)
        {
            $projektovy_zamer_kv=new \stdClass();

            $projektovy_zamer_kv->id=$i;
            $projektovy_zamer_kv->value=$i-527;
            $projektovy_zamer_roky->kv[]=$projektovy_zamer_kv;
        }
        for ($i=2022;$i<2034;$i++)
        {
            $projektovy_zamer_bp=new \stdClass();

            $projektovy_zamer_bp->id=$i;
            $projektovy_zamer_bp->value=$i-513;
            $projektovy_zamer_roky->bp[]=$projektovy_zamer_bp;
        }
        for ($i=2022;$i<2034;$i++)
        {
            $projektovy_zamer_kp=new \stdClass();

            $projektovy_zamer_kp->id=$i;
            $projektovy_zamer_kp->value=$i-76;
            $projektovy_zamer_roky->kp[]=$projektovy_zamer_kp;
        }
        $projektovy_zamer->projektova_idea_roky=$projektovy_zamer_roky;
        $obj->projektovy_zamer=$projektovy_zamer;

        $kvalifikovany_odhad=new \stdClass();
        $kvalifikovany_odhad->kvalifikovany_odhad_ceny_projektu=5500000;
        $kvalifikovany_odhad->kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph=550000;
        $kvalifikovany_odhad->zdroj_info_kvalif_odhad=550000;

        $kvalifikovany_odhad_roky=[];
        for ($i=2022;$i<2034;$i++)
        {
            $kvalifikovany_odhad_item= new \stdClass();
            $kvalifikovany_odhad_item->id=$i;
            $kvalifikovany_odhad_item->value=$i-1517;
            $kvalifikovany_odhad_roky[]=$kvalifikovany_odhad_item;
        }
        $kvalifikovany_odhad->kvalifikovany_odhad_roky=$kvalifikovany_odhad_roky;

        $obj->kvalifikovany_odhad=$kvalifikovany_odhad;



        $interne_udaje=new \stdClass();

        $reporting=new \stdClass();
        $reporting->id=3;
        $reporting->value="Áno";

        $interne_udaje->reporting=$reporting;

        $planovanie_rozpoctu=new \stdClass();
        $planovanie_rozpoctu->id=2;
        $planovanie_rozpoctu->value="Nie";

        $interne_udaje->planovanie_rozpoctu=$planovanie_rozpoctu;
        $interne_udaje->max_rok=2033;
        $interne_udaje->poznamky="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
         ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
         aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
         fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
         laborum.";

        $obj->interne_udaje=$interne_udaje;

        return view('detail')->with('dataset',$obj) ;


    }

    public function testCreate()
    {

        $activity=Activity::find(10);

        //($activity->changes()['old']);

        dump(json_decode($activity->changes(), true)['old']);
        dump(json_decode($activity->changes(), true)['attributes']);
        dump(array_diff( json_decode($activity->changes(), true)['attributes'] , json_decode($activity->changes(), true)['old'] ));
        $changes=array_diff( json_decode($activity->changes(), true)['attributes'] , json_decode($activity->changes(), true)['old'] );

        foreach ($changes as $item=>$key)
        {
            echo "Stará verzia atributu '$item' :".$activity->changes()['old'][$item]."<br>";
             echo "Nová verzia atributu '$item' :".$activity->changes()['attributes'][$item]."<br>";
        }


//
//        User::create([
//            'name'=>'Janko Hrasko',
//            'sn'=>'Janko',
//            'givenName'=>'Hrasko',
//            'email'=>'testlogger5@bratislava.sk',
//            'objectguid'=>'fdfdspfa33pok232porkpo24kpo33231',
//        ]);
//        $user=User::where(['email'=>'testlogger5@bratislava.sk'])->first();
//
//        $user->sn='Karkulka';
//        $user->givenName='Vlkova';
//
//        $user->save();


    }

}

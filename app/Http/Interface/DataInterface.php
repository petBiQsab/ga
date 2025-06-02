<?php

namespace App\Http\Interface;

use App\Models\Aktivity_pp;
use App\Models\Projektove_portfolio;

interface DataInterface
{
    public function getZakladneInformacie(Projektove_portfolio $projekt,$dataset);

    public function getCielProjektu(Projektove_portfolio $projekt);

    public function getStrategickyCielPHSR(Projektove_portfolio $projekt);

    public function getSpecifickyCielPHSR(Projektove_portfolio $projekt);

    public function getProgram(Projektove_portfolio $projekt);

    public function getPrepojenieNaBA30(Projektove_portfolio $projekt, $dataset);

    public function getMeratelnyVystupovyUkazovatel(Projektove_portfolio $projekt);
    public function getZaradenieProjektu(Projektove_portfolio $projekt, $dataset);

    public function getTypProjektu(Projektove_portfolio $projekt);

    public function getKategoria(Projektove_portfolio $projekt);

    public function getPrioritneOblasti(Projektove_portfolio $projekt);

    public function getZivotnyCyklusProjektu(Projektove_portfolio $projekt, $dataset);

    public function getStavProjektu(Projektove_portfolio $projekt);

    public function getFazaProjektu(Projektove_portfolio $projekt);


    public function getTerminyProjektu(Projektove_portfolio $projekt, $dataset);
    public function getRyg(Projektove_portfolio $projekt);
    public function getMuscow(Projektove_portfolio $projekt);
    public function getATL(Projektove_portfolio $projekt);

    public function getDatumZaciatkuProjektu(Projektove_portfolio $projekt);

    public function getDatumKoncaProjektu(Projektove_portfolio $projekt);

    public function getAktivity(Projektove_portfolio $projekt, $dataset);

    public function getStandardneAktivity(Projektove_portfolio $projekt);
    public function getVlastneAktivity(Projektove_portfolio $projekt);
    public function getZodpovedneOsoby(Aktivity_pp $item);
    public function getMTL(Projektove_portfolio $projekt);
    public function getKomentar(Projektove_portfolio $projekt);
    public function getRizikaProjektu(Projektove_portfolio $projekt);
    public function getZrealizovaneAktivity(Projektove_portfolio $projekt);
    public function getPlanovaneAktivity(Projektove_portfolio $projekt);

    public function getOrganizaciaProjektu(Projektove_portfolio $projekt, $dataset);

    public function getDatumSchvaleniaId(Projektove_portfolio $projekt);
    public function getDatumSchvaleniePIPG(Projektove_portfolio $projekt);
    public function getSchvaleniePIPG(Projektove_portfolio $projekt);
    public function getHyperlinkPI(Projektove_portfolio $projekt);
    public function getPripomienkyPI(Projektove_portfolio $projekt);
    public function getSchvaleniePZPG(Projektove_portfolio $projekt);
    public function getDatumSchvaleniePZPG(Projektove_portfolio $projekt);

    public function getHyperlinkPZ(Projektove_portfolio $projekt);
    public function getPripomienkyPZ(Projektove_portfolio $projekt);
    public function getDatumSchvaleniaProjektuPPP(Projektove_portfolio $projekt);
    public function getDatumSchvaleniaProjektuMSZ(Projektove_portfolio $projekt);

    public function getMagistratnyGarant(Projektove_portfolio $projekt);
    public function getPolitickyGarant(Projektove_portfolio $projekt);
    public function getZadavatelProjektu(Projektove_portfolio $projekt);
    public function getProjektovyGarant(Projektove_portfolio $projekt);
    public function getUtvarProjektovehoManagera(Projektove_portfolio $projekt);
    public function getProjektovyManager(Projektove_portfolio $projekt);
    public function getCoopUtvary(Projektove_portfolio $projekt);
    public function getCoopOrganizacie(Projektove_portfolio $projekt);
    public function getExterniStakeholderi(Projektove_portfolio $projekt);
    public function getRiadiaceGremium(Projektove_portfolio $projekt);
    public function getProjektovyTim(Projektove_portfolio $projekt);


    public function getSchvalenieProjektu(Projektove_portfolio $projekt, $dataset);

    public function getExterneFinancovanie(Projektove_portfolio $projekt);
    public function getZdrojExternehoFinancovania(Projektove_portfolio $projekt);
    public function getSumaExternehoFinancovania(Projektove_portfolio $projekt);
    public function getPodielExternehoFinancovania(Projektove_portfolio $projekt);
    public function getMestskaCast(Projektove_portfolio $projekt);
    public function getPriorita(Projektove_portfolio $projekt);
    public function getPrioritaNew(Projektove_portfolio $projekt);
    public function getVerejnaPraca(Projektove_portfolio $projekt);
    public function getSuvisiaceProjekty(Projektove_portfolio $projekt);
    public function getHashtag(Projektove_portfolio $projekt);
    public function getSpecifickeAtributy(Projektove_portfolio $projekt);
    public function getHyperlinkUloziskoProjektu(Projektove_portfolio $projekt);

    public function getDoplnujuceUdaje(Projektove_portfolio $projekt, $dataset);

    public function getCelkoveVydavkyProjektu(Projektove_portfolio $projekt, $dataset);

    public function getNajAktualnejsiaCenaProjektuDPH(Projektove_portfolio $projekt);

    public function getNajAktualnejsieRocnePrevadzkoveNakladyProjektuDPH(Projektove_portfolio $projekt);

    public function getProjektovaIdea(Projektove_portfolio $projekt, $dataset);

    public function getCelkomBVaKVvratDPH(Projektove_portfolio $projekt);
    public function getRocnePrevadzkoveNakladyProjektVratDPH(Projektove_portfolio $projekt);
    public function getIdeaBezneOcakavaneRocneNakladyProjektuDPH(Projektove_portfolio $projekt);
    public function getIdeaKapitaloveOcakRocneNakladyProejtkuDPH(Projektove_portfolio $projekt);
    public function getProjektovaIdeaRokyBV(Projektove_portfolio $projekt);
    public function getProjektovaIdeaRokyKV(Projektove_portfolio $projekt);

    public function getProjektovyZamer(Projektove_portfolio $projekt, $dataset);

    public function getCelkomVratDPH(Projektove_portfolio $projekt);
    public function getRocnePrevadzkoveNakladyVratDPH(Projektove_portfolio $projekt);
    public function getZamerBezneAktulOcakavaneRocneNakladProjektSDPH(Projektove_portfolio $projekt);
    public function getZamerKapitalAktulOcakavaneRocneNakladProjektSDPH(Projektove_portfolio $projekt);
    public function getBeznePrijmyCelkomVratDPH(Projektove_portfolio $projekt);
    public function getKapitalPrijmyCelkomVratDPH(Projektove_portfolio $projekt);
    public function getProjektovyZamerRokyBV(Projektove_portfolio $projekt);
    public function getProjektovyZamerRokyKV(Projektove_portfolio $projekt);
    public function getProjektovyZamerRokyBP(Projektove_portfolio $projekt);
    public function getProjektovyZamerRokyKP(Projektove_portfolio $projekt);

    public function getKvalifikovanyOdhad(Projektove_portfolio $projekt, $dataset);

    public function getKvalifikovanyOdhadCenyProjektu(Projektove_portfolio $projekt);
    public function getKvalifikovanyOdhadRocnychPrevadzkovychNakladovVratDPH(Projektove_portfolio $projekt);
    public function getZdrojInfoKvalifOdhad(Projektove_portfolio $projekt);
    public function getKvalifikovanyOdhadRoky(Projektove_portfolio $projekt);

    public function getInterneUdaje(Projektove_portfolio $projekt, $dataset);

    public function isReportingON(Projektove_portfolio $projekt);
    public function getReporting(Projektove_portfolio $projekt);
    public function getPlanovanieRozpoctu(Projektove_portfolio $projekt);
    public function getMaxRok(Projektove_portfolio $projekt);
    public function getPoznamky(Projektove_portfolio $projekt);
    public function getRGPready(Projektove_portfolio $projekt);
    public function getMTL_Log(Projektove_portfolio $projekt);

    public function getAktivityCiselnik();
    public function getSuvisProjektyCiselnik();
    public function getManagersCiselnik();
    public function getUsers();
    public function getGroups();
    public function getOrganizacie();
    public function findAvailableId();
    public function getNotAvailableId();
}

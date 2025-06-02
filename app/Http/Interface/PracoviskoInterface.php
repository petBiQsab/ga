<?php

namespace App\Http\Interface;

use App\Models\Projektove_portfolio;

interface PracoviskoInterface
{

    public function createDataset();

    public function createDatasetPM($objectguid);

    public function createDatasetLimit($number);

    public function isReportingON(Projektove_portfolio $projekt);
    public function getMtl($item,$dataset);
    public function getMtlLogStatus($item,$dataset);
    public function getAtl($item,$dataset);

    public function getNazovProjektu(Projektove_portfolio $item,$dataset);

    public function getAltNazovProjektu($item,$dataset);

    public function getCielProjektu($item,$dataset);

    public function getStrategickyCielPHSR($item,$dataset);

    public function getSpecifickyCielPHSR($item,$dataset);

    public function getProgram($item,$dataset);

    public function getMeratelnyVystupovyUkazovatel($item,$dataset);

    public function getTypProjektu($item,$dataset);

    public function getKategoriaProjektu($item,$dataset);

    public function getRyg($item,$dataset);
    public function getMuscow($item,$dataset);
    public function getPrioritneOblasti($item,$dataset);

    public function getPlanovanieRozpoctu($item,$dataset);

    public function getDatumZacatiaProjektu($item,$dataset);

    public function getDatumKoncaProjektu($item,$dataset);

    public function getStavProjektu($item,$dataset);

    public function getFazaProjektu($item,$dataset);

    public function getPoslednaUkoncenaAktivita($item,$dataset);

    public function getZadavatelProjektu($item,$dataset);

    public function getPolitickyGarant($item,$dataset);

    public function getMagistratnyGarant($item,$dataset);

    public function getProjektovyGarant($item,$dataset);

    public function getUtvarProjektovehoManagera($item,$dataset);

    public function getProjektovyManager($item,$dataset);

    public function getCoopUtvary($item,$dataset);

    public function getCoopOrganizacie($item,$data);

    public function getProjektovyTim($item,$dataset);

    public function getUdrzba($item,$dataset);

    public function getSprava($item,$dataset);

    public function getRiadiaceGremium($item,$dataset);

    public function getDatumSchvaleniaPIPG($item,$dataset);

    public function getDatumSchvaleniaPZPG($item,$dataset);
    public function getDatumSchvaleniaProjektuPPP($item,$dataset);
    public function getDatumSchvaleniaProjektuMsZ($item,$dataset);
    public function getSumaExternehoFinancovania($item,$dataset);

    public function getZdrojExternehoFinancovania($item,$dataset);

    public function getMestskaCast($item,$dataset);

    public function getPriorita($item,$dataset);
    public function getPriorityOld($item,$dataset);
    public function getSpecifickeAtributy($item,$dataset);

    public function getHashtagy($item,$dataset);

    public function getReporting($item,$dataset);

    public function getReportingFilter($item,  $dataset);

    public function getMojeUtvary($id_user);

    public function getPriority($item, $dataset);
    public function getExterniStakeholderi($item, $dataset);
    public function getDatumSchvaleniaProjektu($item, $dataset);
    public function getSchvaleniePIPG($item, $dataset);
    public function getHyperlinkPI($item, $dataset);
    public function getPripomienkyPI($item, $dataset);
    public function getSchvaleniePZPG($item, $dataset);
    public function getHyperlinkPZ($item, $dataset);
    public function getPripomienkyPZ($item, $dataset);
    public function getExterneFinancovanie($item, $dataset);
    public function getPodielExtFinancovania($item, $dataset);
    public function getSuvisiaceProjekty($item, $dataset);
    public function getHyperlinkUloziskoProjektu($item, $dataset);
    public function getNajaktualnejsiaCenaProjektuDPH($item, $dataset);
    public function getNajaktualRocnePrevadzkoveNakladyProjektuDPH($item, $dataset);
    public function getMaxRok($item, $dataset);
    public function getPoznamky($item, $dataset);
}

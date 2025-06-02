<?php

namespace App\Exports\Reports;

use App\Exports\Reports\Data\RgpDataProvider;
use App\Http\Interface\ExportInterface\ExportInterface;
use App\Models\Projektove_portfolio;
use Carbon\Carbon;

class RGP implements ExportInterface
{

    protected RgpDataProvider $rgpData;

    public function __construct(RgpDataProvider $rgpData)
    {
        $this->rgpData=$rgpData;
    }

    public function export($id)
    {
        $data=new \stdClass();

        $projekt=$this->rgpData->getProjektById($id);
        $data->nazov_projektu=$projekt->nazov_projektu;
        $data->id_projekt=$projekt->id_projekt;
        $data->zaciatok_projektu=$this->rgpData->getZaciatokProjektu($projekt);
        $data->koniec_projektu=$this->rgpData->getKoniecProjektu($projekt);
        $data->typ_projektu=$this->rgpData->getTypProjektu($projekt);
        $data->projektovy_tim=$this->rgpData->getProjektTim($projekt);
        $data->riadiace_gremium=$this->rgpData->getRiadiaceGremium($projekt);

        //gant
        $data->projekt_manazer=$this->rgpData->getProjektovyManager($projekt);
        $data->projektovy_manager_email=$this->rgpData->getProjektovyManagerEmail($projekt);

        $data->zrealizovane_aktivity=$this->rgpData->getZrealizovaneAktivity($projekt);
        $data->planovane_aktivity=$this->rgpData->getPlanovaneAktivity($projekt);
        $data->rizika_projektu=$this->rgpData->getRizikaProjektu($projekt);
        $data->kategoria=$this->rgpData->getKategoriaProjektu($projekt);
        $data->komentarMTL=$this->rgpData->getKomentarMTL($projekt);
        $data->mtl=$this->rgpData->getMTL($projekt);
        $data->atl=$this->rgpData->getATL($projekt);
        $data->financovanie=$this->rgpData->getFinancovanie($projekt);
        $data->aktivity=$this->rgpData->gant($projekt);

        $dataArr=[
            'nazov_projektu'=>$data->nazov_projektu,
            'id_projekt'=>$data->id_projekt,
            'zaciatok_projektu'=>$data->zaciatok_projektu,
            'koniec_projektu'=>$data->koniec_projektu,
            'typ_projektu'=>$data->typ_projektu,
            'projektovy_tim'=>$data->projektovy_tim,
            'riadiace_gremium'=>$data->riadiace_gremium,
            'projekt_manazer'=>$data->projekt_manazer,
            'projektovy_manager_email'=>$data->projektovy_manager_email,
            'zrealizovane_aktivity'=>$data->zrealizovane_aktivity,
            'planovane_aktivity'=>$data->planovane_aktivity,
            'rizika_projektu'=>$data->rizika_projektu,
            'komentarMTL'=>$data->komentarMTL,
            'kategoria'=>$data->kategoria,
            'mtl'=>$data->mtl,
            'atl'=>$data->atl,
            'financovanie'=>$data->financovanie,
            'aktivity'=>$data->aktivity,

        ];
        return $dataArr;
    }

}

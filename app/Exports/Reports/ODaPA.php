<?php

namespace App\Exports\Reports;

use App\Exports\Reports\Data\RgpDataProvider;
use App\Models\Projektove_portfolio;

class ODaPA
{
    protected RgpDataProvider $rgpData;

    public function __construct(RgpDataProvider $rgpData)
    {
        $this->rgpData = $rgpData;
    }

    private function listActivities($rgp_gant_data)
    {
        $activities=[];
        if (isset($rgp_gant_data->page))
        {
            foreach ($rgp_gant_data->page as $data)
            {
                foreach ($data as $items)
                {
                    $activities[]=$items;
                    if (isset($items->partOne))
                    {
                        unset($items->partOne);
                    }
                    if (isset($items->partTwo))
                    {
                        unset($items->partTwo);
                    }
                    if (isset($items->partThree))
                    {
                        unset($items->partThree);
                    }
                    if (isset($items->finished))
                    {
                        unset($items->finished);
                    }
                    if (isset($items->date))
                    {
                        unset($items->date);
                    }

                }
            }
        }

        return $activities;
    }

    public function dump_project_details()
    {
        $dataset=[];

        $results=Projektove_portfolio::all();

        foreach ($results as $projekt)
        {
            $project_data=new \stdClass();

            $project_data->id_projektu=$projekt->id_projekt;
            $project_data->nazov_projektu=$projekt->nazov_projektu;
            $project_data->alt_nazov_projektu=$projekt->alt_nazov_projektu;
            $project_data->ciel_projektu=$this->rgpData->getCielProjektu($projekt);
            $project_data->zaciatok_projektu=$this->rgpData->getZaciatokProjektu($projekt);
            $project_data->koniec_projektu=$this->rgpData->getKoniecProjektu($projekt);
            $project_data->typ_projektu=$this->rgpData->getTypProjektu($projekt);
            $project_data->kategoria=$this->rgpData->getKategoriaProjektu($projekt);
            $project_data->stav_projektu=$this->rgpData->getStavProjektu($projekt);
            $project_data->faza_projektu=$this->rgpData->getFazaProjektu($projekt);
            $project_data->mtl=$this->rgpData->getMTL($projekt);
            $project_data->atl=$this->rgpData->getATL($projekt);
            $project_data->aktivity=$this->listActivities($this->rgpData->gant($projekt));

            $dataset[]=$project_data;
        }
        return json_encode($dataset,JSON_UNESCAPED_UNICODE);
    }

}

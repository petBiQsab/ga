<?php

namespace App\Http\Factories;

use App\Exports\Reports\Data\RgpDataProvider;
use App\Exports\Reports\ODaPA;
use App\Exports\Reports\RGP;

class ExportFactory
{
    public function initExport($reportType,$id)
    {
        if ($reportType=="rgp")
        {
            $rgpDataInstance = new RgpDataProvider();
            $rgp = new RGP($rgpDataInstance);
            return $rgp->export($id);
        }
        if ($reportType=="odapa_dump_project_details")
        {
            $rgpDataInstance = new RgpDataProvider();
            $export = new ODaPA($rgpDataInstance);
            return $export->dump_project_details();

        }
    }
}

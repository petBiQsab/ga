<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Projektove_portfolio;
use App\Models\Reporting;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovePortfolioSeeder extends DatabaseSeeder
{
    private function findReportingID($id)
    {
        $data=Reporting::where(['id'=>$id])->value('id');
        return ($data!=null) ? $data : null;

    }

    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->get();

        foreach ($data as $value) {
            $projekt=Projektove_portfolio::create(
                [
                    'id_projekt'=>$value->id_projekt,
                    'nazov_projektu'=>$value->nazov,
                    'alt_nazov_projektu'=>$value->alt_nazov,
                    'id_reporting'=>$this->findReportingID($value->reporting),
                    'id_planovanie_rozpoctu' => $value->plan_rozpocet,
                    'max_rok'=>2030,
                    'created_by'=>$value->updated_by
                ]);
            $projekt->id_original=$projekt->id;
            $projekt->save();
        }
    }
}

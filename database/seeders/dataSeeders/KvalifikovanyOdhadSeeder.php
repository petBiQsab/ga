<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Kvalifikovany_odhad;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class KvalifikovanyOdhadSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Kvalifikovany_odhad::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'kvalifikovany_odhad_ceny_projektu'=>$value->kvalifikovany_odhad_ceny_projektu,
                    'kvalifikovany_odhad_rocnych_prevadzkovych_nakladov_vrat_dph'=>$value->kvalif_odhad_roc_prevadz_naklad_dph,
                    'zdroj_info_kvalif_odhad'=>$value->zdroj_info_kvalif_odhad,
                ]);
        }
    }
}

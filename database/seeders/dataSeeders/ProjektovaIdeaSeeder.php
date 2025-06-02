<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Doplnujuce_udaje;
use App\Models\Projektova_idea;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovaIdeaSeeder extends DatabaseSeeder
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
            Projektova_idea::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'celkom_bv_a_kv_vrat_dph'=>$value->celkom_BV_a_KV_vrat_DPH,
                    'rocne_prevadzkove_naklady_projektu_vrat_dph'=>$value->rocne_prevadz_naklady_projektu_DPH,
                    'idea_bezne_ocakavane_rocne_naklady_projektu_s_dph'=>$value->aktual_ocak_rocne_naklady_projektu,
                    'idea_kapitalove_ocakavane_rocne_naklady_projektu_s_dph'=>$value->idea_kapitalove_celkom_s_DPH,

                ]);
        }
    }
}

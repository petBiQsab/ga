<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Projektova_idea;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_zamer;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovyZamerSeeder extends DatabaseSeeder
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
            Projektovy_zamer::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'celkom_vrat_dph'=>$value->zamer_celkom_s_DPH,
                    'rocne_prevadzkove_naklady_vrat_dph'=>$value->zamer_aktualne_ocakavane_rocne_naklady_projektu_s_DPH,
                    'zamer_bezne_aktualne_ocakavane_rocne_naklady_projektu_s_dph'=>$value->zamer_bezne_celkom_s_DPH,
                    'zamer_kapitalove_aktualne_ocakavane_rocne_naklady_projektu_s_dph'=>$value->zamer_kapitalove_celkom_s_DPH,
                    'bezne_prijmy_celkom_vrat_dph'=>$value->bezne_prijmy_celkom_vrat_DPH,
                    'kapitalove_prijmy_celkom_vrat_dph'=>$value->kapitalove_prijmy_celkom_vrat_DPH,

                ]);
        }
    }
}


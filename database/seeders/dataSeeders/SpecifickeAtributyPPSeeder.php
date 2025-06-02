<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Hashtag;
use App\Models\Projektove_portfolio;
use App\Models\Specificke_atributy;
use App\Models\Specificke_atributy_pp;
use Database\Seeders\DatabaseSeeder;
use DB;

class SpecifickeAtributyPPSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : null;
    }

    private function findSpecifickeAtributyID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('portfolio_specificke_atributy')->where(['id' => $id,'visible'=>1])->value('name');
        $id=Specificke_atributy::where(['value'=>$data])->value('id');

        return ($id!=null) ? $id : null;
    }
    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_specificke_atributy_portfolio')->whereIn('project_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Specificke_atributy_pp::create(
                [
                    'id_pp'=>$this->findOriginalID($value->project_id),
                    'id_speci_atribut'=>$this->findSpecifickeAtributyID($value->speci_atribut_id),
                ]);
        }
    }
}


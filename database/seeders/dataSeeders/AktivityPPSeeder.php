<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Aktivity_pp;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class AktivityPPSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    private function checkAktivityBlacklist(int $id): bool
    {
        $blacklist=[9,13,17,21,26,45,49];
        if (in_array($id,$blacklist))
        {
            return false;
        }
        return true;
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_aktivity_projektu_assigned')->whereIn('project_id',$data_pp_ids)->get();
        foreach ($data as $value) {

            if ($value->text==null)
            {
                if ($this->checkAktivityBlacklist($value->aktivity_prj_id)===false)
                {
                    continue;
                }
            }

            Aktivity_pp::create(
                [
                    'id_pp'=>$this->findOriginalID($value->project_id),
                    'id_aktivita'=>$value->aktivity_prj_id,
                    'vlastna_aktivita'=>$value->text,
                    'zaciatok_aktivity'=>$value->start_date,
                    'koniec_aktivity'=>$value->end_date,
                ]);
        }
    }
}


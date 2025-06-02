<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Phsr_pp;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class PhsrPPSeeder extends DatabaseSeeder
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
        $data = DB::connection('portfolio_old_db')->table('portfolio_phsr_portfolio')->whereIn('project_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Phsr_pp::create(
                [
                    'id_pp'=>$this->findOriginalID($value->project_id),
                    'id_phsr'=>$value->phsr_id,
                ]);
        }
    }
}

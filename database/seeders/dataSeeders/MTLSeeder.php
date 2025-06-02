<?php

namespace Database\Seeders\dataSeeders;

use App\Models\MTL;
use App\Models\Phsr_pp;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class MTLSeeder extends DatabaseSeeder
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
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio')->whereIn('id',$data_pp_ids)->get();

        foreach ($data as $value) {
            MTL::create(
                [
                    'id_pp'=>$this->findOriginalID($value->id),
                    'status' => $value->mtl_status,
                    'history' => $value->mtl_history,
                    'reset' => $value->mtl_reset,
                    'komentar' => $value->mtl_komentar,
                    'status_user' => $value->mtl_status_user,
                ]);
        }
    }
}


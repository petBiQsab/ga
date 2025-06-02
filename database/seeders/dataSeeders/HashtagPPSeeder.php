<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Hashtag;
use App\Models\Hashtag_pp;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class HashtagPPSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : null;
    }

    private function findHashtagID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('portfolio_hashtag')->where(['id' => $id,'visible'=>1])->value('name');

        $id=Hashtag::where(['value'=>$data])->value('id');

        return ($id!=null) ? $id : null;
    }


    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_hashtag_portfolio')->whereIn('project_id',$data_pp_ids)->get();

        foreach ($data as $value) {
           Hashtag_pp::create(
                [
                    'id_pp'=>$this->findOriginalID($value->project_id),
                    'id_hashtag'=>$this->findHashtagID($value->hashtag_id),
                ]);
        }
    }
}


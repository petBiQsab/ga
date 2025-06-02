<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Projektove_portfolio;
use App\Models\Projektovy_tim;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovyTimSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }



    private function findIfUserExists($id)
    {
        $data=User::where(['objectguid'=>$id])->value('objectguid');

        if ($data!=null)
        {
            return $data;
        }else {
            return null;
        }


    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_projektovy_tim')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            if ($this->findIfUserExists($value->user)!=null)
            {
                Projektovy_tim::create(
                    [
                        'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                        'id_user'=>$value->user,
                    ]);
            }

        }
    }
}

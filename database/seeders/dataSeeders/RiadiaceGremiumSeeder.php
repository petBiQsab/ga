<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Coop_utvary;
use App\Models\Projektove_portfolio;
use App\Models\Riadiace_gremium;
use Database\Seeders\DatabaseSeeder;
use DB;

class RiadiaceGremiumSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    private function checkUser($objectguid)
    {
        $result=DB::table('users')->where('objectguid', $objectguid)->exists();
        return $result ? $objectguid : null;
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_riadiace_gremium')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            if ($this->checkUser($value->user)!=null)
            {
                Riadiace_gremium::create(
                    [
                        'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                        'id_user'=>$value->user,
                    ]);
            }


        }
    }
}

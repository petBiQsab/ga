<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Aktivity_pp;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovyManagerPPSeeder extends DatabaseSeeder
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
        $data = DB::connection('portfolio_old_db')->table('portfolio_projekt_manager')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            if ($this->checkUser($value->user)!=null) {
                Projektovy_manazer_pp::create(
                    [
                        'id_pp' => $this->findOriginalID($value->projekt_portfolio_id),
                        'id_user' => $value->user,
                    ]);
            }
        }
    }
}

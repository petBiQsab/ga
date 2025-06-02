<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Organizacia_projektu;
use App\Models\Projektove_portfolio;
use App\Models\Reporting;
use Database\Seeders\DatabaseSeeder;
use DB;

class OrganizaciaProjektuSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    private function checkGroup($objectguid)
    {
        $result=DB::table('groups')->where('objectguid', $objectguid)->exists();
        return $result ? $objectguid : null;
    }

    private function checkUser($objectguid)
    {
        $result=DB::table('users')->where('objectguid', $objectguid)->exists();
        return $result ? $objectguid : null;
    }
    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();


        foreach ($data as $value) {
                Organizacia_projektu::create(
                    [
                        'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                        'id_zadavatel_projektu'=>$this->checkGroup($value->zadavatel_projektu),
                        'id_projektovy_garant'=>$this->checkUser($value->projektovy_garant),
                        'externi_stakeholderi'=>$value->externi_stakeholderi,
                    ]);
        }
    }
}

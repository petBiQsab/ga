<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Coop_organizacie;
use App\Models\Coop_utvary;
use App\Models\Groups;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class CoopOrganizacieSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }



    private function convertIcoToObjectguid($ico)
    {
        $objectguid=Groups::where(['ico' => $ico])->value('objectguid');

        return $objectguid ? $objectguid : null;
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_coop_projekt_organizacie')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Coop_organizacie::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'id_group'=>$this->convertIcoToObjectguid($value->groupName),
                ]);
        }
    }
}

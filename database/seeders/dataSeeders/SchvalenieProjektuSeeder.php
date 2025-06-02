<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Organizacia_projektu;
use App\Models\Projektove_portfolio;
use App\Models\Schvalenie_projektu;
use Database\Seeders\DatabaseSeeder;
use DB;

class SchvalenieProjektuSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    private function findAtributeAndValue($attr, $id)
    {
        $data_pp = DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1,'id'=>$id])->value($attr);
        return $data_pp;
    }


    private function checkDate($date)
    {
       if (($date=="1970-01-01") or ($date=="1900-01-21") or ($date=="1900-01-20"))
       {
           return null;
       }else return $date;

    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Schvalenie_projektu::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'datum_schvalenia_ID'=>$this->checkDate($value->datum_schvalenia_id),
                    'id_schvalenie_pi_na_pg'=>$value->schvalenie_PI_na_PG,
                    'datum_schvalenia_pi_na_pg'=>$this->checkDate($value->datum_schvalenia_PI_na_PG),
                    'hyperlink_na_pi'=>$value->link_pi_pg,
                    'pripomienky_k_pi'=>$value->pripomienky_k_PI,
                    'id_schvalenie_pz_na_pg'=>$value->schvalenie_PZ_na_PG,
                    'datum_schvalenia_pz_na_pg'=>$this->checkDate($value->datum_schvalenia_PZ_na_PG),
                    'hyperlink_na_pz'=>$value->link_pz_pg,
                    'pripomienky_k_pz'=>$value->pripomienky_k_PZ,
                    'datum_schvalenia_projektu_ppp'=>$this->checkDate($value->datum_schvalenia_projektu_ppp),
                    'datum_schvalenia_projektu_msz'=>$this->checkDate($value->datum_schvalenia_projektu_msz),

                ]);
        }
    }
}

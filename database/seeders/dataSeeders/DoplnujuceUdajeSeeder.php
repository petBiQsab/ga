<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Doplnujuce_udaje;
use App\Models\Projektove_portfolio;
use App\Models\Verejna_praca;
use Database\Seeders\DatabaseSeeder;
use DB;

class DoplnujuceUdajeSeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    private function findVerejnaPracaId($value)
    {
        if ($value==0)
        {
            return 2;
        }
        $data=Verejna_praca::where(['value'=>$value])->value('id');
        return ($data!=null) ? $data : 2;
    }

    private function findAtributeAndValue($attr, $id)
    {
        $data_pp = DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1,'id'=>$id])->value($attr);
        return $data_pp;
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            Doplnujuce_udaje::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'id_externe_financovanie'=>$value->externe_financovanie,
                    'zdroj_externeho_financovania'=>$value->zdroj_ext_financovania,
                    'suma_externeho_financovania'=>$value->suma_ext_financovania,
                    'podiel_externeho_financovania_z_celkovej_ceny'=>$value->podiel_ext_financ_z_celk_ceny,
                    'id_priorita'=>$value->priorita,
                    'id_priorita_new'=>$this->findAtributeAndValue('priorita',$value->projekt_portfolio_id),
                    'id_verejna_praca'=>$this->findVerejnaPracaId($value->verejna_praca) ,
                    'hyperlink_na_ulozisko_projektu'=>$value->link_pi_ulozisko,
                    ]);
        }
    }
}


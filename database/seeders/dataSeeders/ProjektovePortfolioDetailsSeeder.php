<?php

namespace Database\Seeders\dataSeeders;


use App\Models\Projektove_portfolio;
use App\Models\Projektove_portfolio_details;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovePortfolioDetailsSeeder extends DatabaseSeeder
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
    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data_ppd = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data_ppd as $value) {
            if ($value->stav_projektu_id>6)
            {
                $value->stav_projektu_id=$value->stav_projektu_id-3;
            }
            $projekt=Projektove_portfolio_details::create(
                [
                    'id_pp'=>$this->findOriginalID($value->projekt_portfolio_id),
                    'ciel_projektu'=>$this->findAtributeAndValue('ciel_projektu',$value->projekt_portfolio_id),
                    'meratelny_vystupovy_ukazovatel'=>$this->findAtributeAndValue('meratelny_vystup_ukazovatel',$value->projekt_portfolio_id),
                    'id_kategoria_projektu'=>$this->findAtributeAndValue('kategoria',$value->projekt_portfolio_id),
                    'id_stav_projektu'=>$value->stav_projektu_id,
                    'id_faza_projektu'=>$value->faza_projektu_id,
                    'datum_zacatia_projektu'=>$this->findAtributeAndValue('plan_datum_start_project',$value->projekt_portfolio_id),
                    'datum_konca_projektu'=>$this->findAtributeAndValue('plan_datum_end_project',$value->projekt_portfolio_id),
                    'rizika_projektu'=>$value->rizika_projektu,
                    'zrealizovane_aktivity'=>$value->zrealizovane_aktivity,
                    'planovane_aktivity_na_najblizsi_tyzden'=>$value->planovane_aktivity,
                    'najaktualnejsia_cena_projektu_vrat_DPH'=>$value->najaktual_cena_projektu_vrat_DPH,
                    'najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH'=>$value->najaktual_rocne_prevadz_naklady_projekt_DPH,
                    'poznamky'=>$value->poznamky,

                ]);
        }
    }
}


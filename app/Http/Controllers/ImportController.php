<?php

namespace App\Http\Controllers;

use App\Models\Aktivity_pp;
use App\Models\Projektove_portfolio;
use DB;

class ImportController extends Controller
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : null;
    }

    private function checkAktivityBlacklist(int $id): bool
    {
        $blacklist=[9,13,17,21,26,45,49];
        if (in_array($id,$blacklist))
        {
            return false;
        }
        return true;
    }

    public function index()
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('portfolio_aktivity_projektu_assigned')->whereIn('project_id',$data_pp_ids)->get();
        $counter=0;
        $counter2=0;

        foreach ($data as $value) {
            if ($value->text==null)
            {
                if ($this->checkAktivityBlacklist($value->aktivity_prj_id)===false)
                {
                    continue;
                }
            }
            //$aktivita=Aktivity_pp::where(['id_pp' => $this->findOriginalID($value->project_id)])->first();
            $aktivita = Aktivity_pp::where('id_pp', $this->findOriginalID($value->project_id))
                ->where(function ($query) use ($value) {
                    $query->where('id_aktivita', $value->aktivity_prj_id);

                })
                ->first();

            if ($aktivita!=null)
            {
                if($value->start_date_confirm==1)
                {
                    if ($aktivita->skutocny_zaciatok_aktivity==null)
                    {
                        $aktivita->skutocny_zaciatok_aktivity=$value->start_date;
                        //$aktivita->save();
                        $counter=$counter+1;
                    }
                }
                if($value->end_date_confirm==1)
                {
                    if ($aktivita->skutocny_koniec_aktivity==null)
                    {
                        $aktivita->skutocny_koniec_aktivity=$value->end_date;
                       // $aktivita->save();
                        $counter2=$counter2+1;
                    }
                }
            }
        }
//        dump($counter);
//        dd($counter2);
    }
}

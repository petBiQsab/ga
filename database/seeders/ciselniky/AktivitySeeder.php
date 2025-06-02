<?php

namespace Database\Seeders\ciselniky;

use App\Models\Aktivity;
use Database\Seeders\DatabaseSeeder;
use DB;

class AktivitySeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data=DB::connection('portfolio_old_db')->table('portfolio_aktivity_projektu')->get();

        foreach ($data as $value) {
            if ($value->headerTitle=="Projektová príprava")
            {
                $orderNum=1;
            }
            if ($value->headerTitle=="Realizácia")
            {
                $orderNum=2;
            }
            if ($value->headerTitle=="Obstarávanie")
            {
                $orderNum=3;
            }
            if ($value->headerTitle=="Financovanie")
            {
                $orderNum=4;
            }

//            if ($value->name=="Územné rozhodnutie právoplatné"
//                or $value->name=="Stavebné povolenie právoplatné"
//                or $value->name=="Stavba skolaudovaná"
//                or $value->name=="Žiadosť o NFP schválená"
//                or $value->name=="Posledná žiadosť o platbu uzavretá"
//            )
//            {
//                continue;
//            }

            //premenovanie
            if ($value->id==18)
            {
                $value->name="Zmluvy o preložkách";
            }

            if ($value->id==22)
            {
                $value->name="Ohlásenie stavby";
            }

            if ($value->id==27)
            {
                $value->name="Odovzdanie stavby do správy";
            }

            if ($value->id==28)
            {
                $value->name="Zaradenie stavby do majetku";
            }

            if ($value->id==23)
            {
                $value->name="Odovzdanie staveniska";
            }

            if ($value->id==33)
            {
                $value->name="Podpis zmluvy pre dokumentáciu";
            }

            if ($value->name=="Objednávka z rámcovej zmluvy na dokumentáciu vystavená")
            {
                $value->name="Vystavenie objednávky z RZ pre dokumentáciu";
            }

            if ($value->id==37)
            {
                $value->name="Podpis zmluvy pre stavebný dozor";
            }

            if ($value->name=="Objednávka z rámcovej zmluvy na stavebný dozor vystavená")
            {
                $value->name="Vystavenie objednávky z RZ pre stavebný dozor";
            }

            if ($value->id==41)
            {
                $value->name="Podpis zmluvy pre realizáciu";
            }

            if ($value->name=="Objednávka z rámcovej zmluvy na realizáciu vystavená")
            {
                $value->name="Vystavenie objednávky z RZ pre realizáciu";
            }

            if ($value->id==47)
            {
                $value->name="Podpis zmluvy o NFP";
            }






            Aktivity::create(
                ['name'=>$value->name,
                'id_kategoria'=>$orderNum,
                'flag'=>$value->flag,
                'note'=>$value->note
                ]);
        }

        Aktivity::create(
            ['name'=>"Odovzdanie dokumentácie do realizačnej fázy",
                'id_kategoria'=>1,
                'flag'=>"A",
                'note'=>null,
            ]);

        Aktivity::create(
            ['name'=>"Odovzdávaco - preberacie konanie",
                'id_kategoria'=>2,
                'flag'=>"A",
                'note'=>null,
            ]);

        Aktivity::create(
            ['name'=>"Schvaľovanie zámeru o NFP",
                'id_kategoria'=>4,
                'flag'=>"A",
                'note'=>null,
            ]);
    }
}

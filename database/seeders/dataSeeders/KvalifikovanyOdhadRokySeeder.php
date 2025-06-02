<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Kvalifikovany_odhad_roky;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class KvalifikovanyOdhadRokySeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    public function run(): void
    {
        $data_pp_ids = DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible' => 1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id', $data_pp_ids)->get();

        foreach ($data as $value) {
            $id = $this->findOriginalID($value->projekt_portfolio_id);
            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2021,
                    'value' => $value->financovanie_rok_minus,
                ]);
            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2022,
                    'value' => $value->financovanie_rok_0,
                ]);
            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2023,
                    'value' => $value->financovanie_rok_1,
                ]);
            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2024,
                    'value' => $value->financovanie_rok_2,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2025,
                    'value' => $value->financovanie_rok_3,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2026,
                    'value' => $value->financovanie_rok_4,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2027,
                    'value' => $value->financovanie_rok_5,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2028,
                    'value' => $value->financovanie_rok_6,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2029,
                    'value' => $value->financovanie_rok_7,
                ]);

            Kvalifikovany_odhad_roky::create(
                [
                    'id_pp' => $id,
                    'rok' => 2030,
                    'value' => $value->financovanie_rok_8,
                ]);
        }
    }
}

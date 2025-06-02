<?php

namespace Database\Seeders\dataSeeders;

use App\Models\Projektova_idea;
use App\Models\Projektova_idea_roky;
use App\Models\Projektove_portfolio;
use Database\Seeders\DatabaseSeeder;
use DB;

class ProjektovaIdeaRokySeeder extends DatabaseSeeder
{
    private function findOriginalID($id)
    {
        $data= DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['id' => $id,'visible'=>1])->value('id_projekt');
        $id=Projektove_portfolio::where(['id_projekt'=>$data])->value('id');

        return ($id!=null) ? $id : dd($data);
    }

    public function run(): void
    {
        $data_pp_ids=DB::connection('portfolio_old_db')->table('projekt_portfolio')->where(['visible'=>1])->pluck('id')->toArray();
        $data = DB::connection('portfolio_old_db')->table('projekt_portfolio_advanced')->whereIn('projekt_portfolio_id',$data_pp_ids)->get();

        foreach ($data as $value) {
            $id=$this->findOriginalID($value->projekt_portfolio_id);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2021,
                    'value'=>$value->idea_bezne_rok_minus,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2022,
                    'value'=>$value->idea_bezne_rok_0,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2023,
                    'value'=>$value->idea_bezne_rok_1,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2024,
                    'value'=>$value->idea_bezne_rok_2,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2025,
                    'value'=>$value->idea_bezne_rok_3,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2026,
                    'value'=>$value->idea_bezne_rok_4,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2027,
                    'value'=>$value->idea_bezne_rok_5,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2028,
                    'value'=>$value->idea_bezne_rok_6,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2029,
                    'value'=>$value->idea_bezne_rok_7,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"BV",
                    'rok'=>2030,
                    'value'=>$value->idea_bezne_rok_8,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2021,
                    'value'=>$value->idea_kapitalove_rok_minus,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2022,
                    'value'=>$value->idea_kapitalove_rok_0,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2023,
                    'value'=>$value->idea_kapitalove_rok_1,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2024,
                    'value'=>$value->idea_kapitalove_rok_2,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2025,
                    'value'=>$value->idea_kapitalove_rok_3,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2026,
                    'value'=>$value->idea_kapitalove_rok_4,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2027,
                    'value'=>$value->idea_kapitalove_rok_5,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2028,
                    'value'=>$value->idea_kapitalove_rok_6,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2029,
                    'value'=>$value->idea_kapitalove_rok_7,
                ]);
            Projektova_idea_roky::create(
                [
                    'id_pp'=>$id,
                    'typ'=>"KV",
                    'rok'=>2030,
                    'value'=>$value->idea_kapitalove_rok_8,
                ]);

        }
    }
}


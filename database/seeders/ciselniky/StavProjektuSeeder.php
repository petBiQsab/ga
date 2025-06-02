<?php

namespace Database\Seeders\ciselniky;

use App\Models\Stav_projektu;
use Database\Seeders\DatabaseSeeder;
use DB;

class StavProjektuSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_stav_projektu')->where(['visible'=>1])->get();

        foreach ($data as $value) {
            Stav_projektu::create(
                [
                    'value' => $value->nazov,
                ]);
        }
    }
}


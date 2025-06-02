<?php

namespace Database\Seeders\ciselniky;

use App\Models\Faza_projektu;
use Database\Seeders\DatabaseSeeder;
use DB;

class FazaProjektuSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data=DB::connection('portfolio_old_db')->table('portfolio_faza_projektu')->get();

        foreach ($data as $value) {
            Faza_projektu::create(
                [
                    'value' => $value->nazov,
                ]);
        }
    }
}

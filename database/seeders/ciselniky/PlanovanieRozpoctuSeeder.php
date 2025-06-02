<?php

namespace Database\Seeders\ciselniky;

use App\Models\Planovanie_rozpoctu;
use Database\Seeders\DatabaseSeeder;
use DB;

class PlanovanieRozpoctuSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_planovanie_rozpoctu')->get();

        foreach ($data as $value) {
            Planovanie_rozpoctu::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

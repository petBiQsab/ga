<?php

namespace Database\Seeders\ciselniky;

use App\Models\Politicka_priorita;
use Database\Seeders\DatabaseSeeder;
use DB;

class PoslaneckaPrioritaSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_priorita')->get();

        foreach ($data as $value) {
            Politicka_priorita::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

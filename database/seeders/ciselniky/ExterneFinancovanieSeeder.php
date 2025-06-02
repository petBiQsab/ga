<?php

namespace Database\Seeders\ciselniky;

use App\Models\Externe_financovanie;
use Database\Seeders\DatabaseSeeder;
use DB;

class ExterneFinancovanieSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data=DB::connection('portfolio_old_db')->table('portfolio_externe_financovanie')->get();

        foreach ($data as $value) {
            Externe_financovanie::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

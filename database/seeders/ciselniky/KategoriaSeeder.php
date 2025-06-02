<?php

namespace Database\Seeders\ciselniky;

use App\Models\Kategoria;
use Database\Seeders\DatabaseSeeder;
use DB;

class KategoriaSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_kategoria_projektu')->get();

        foreach ($data as $value) {
            Kategoria::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

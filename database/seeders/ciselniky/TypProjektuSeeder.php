<?php

namespace Database\Seeders\ciselniky;

use App\Models\Typ_projektu;
use Database\Seeders\DatabaseSeeder;
use DB;

class TypProjektuSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_typ_vydavku')->get();

        foreach ($data as $value) {
            Typ_projektu::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

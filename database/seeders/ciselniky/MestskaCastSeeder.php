<?php

namespace Database\Seeders\ciselniky;

use App\Models\Mestska_cast;
use Database\Seeders\DatabaseSeeder;
use DB;

class MestskaCastSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('mestske_casti')->get();

        foreach ($data as $value) {
            Mestska_cast::create(
                [
                    'value' => $value->nazov,
                ]);
        }
    }
}

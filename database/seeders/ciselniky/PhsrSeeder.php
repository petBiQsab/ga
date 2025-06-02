<?php

namespace Database\Seeders\ciselniky;

use App\Models\Phsr;
use Database\Seeders\DatabaseSeeder;
use DB;

class PhsrSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_phsr')->where(['visible'=>1])->get();

        foreach ($data as $value) {
            Phsr::create(
                [
                    'value' => $value->name,
                    'type' => $value->type
                ]);
        }
    }
}


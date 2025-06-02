<?php

namespace Database\Seeders\ciselniky;

use App\Models\Reporting;
use Database\Seeders\DatabaseSeeder;
use DB;

class ReportingSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_reporting')->get();

        foreach ($data as $value) {
            Reporting::create(
                [
                    'value' => $value->name,
                ]);
        }
    }
}

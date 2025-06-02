<?php

namespace Database\Seeders\ciselniky;

use App\Models\Hashtag;
use Database\Seeders\DatabaseSeeder;
use DB;

class HashtagSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        $data = DB::connection('portfolio_old_db')->table('portfolio_hashtag')->where(['visible'=>1])->get();

        foreach ($data as $value) {
            Hashtag::create(
            [
                'value' => $value->name,
            ]);
        }
    }
}

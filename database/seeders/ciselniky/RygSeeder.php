<?php

namespace Database\Seeders\ciselniky;

use App\Models\RYG;
use Database\Seeders\DatabaseSeeder;

class RygSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Red'],
        ['value'=>'Yellow'],
        ['value'=>'Green'],

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            RYG::create($value);
        }
    }
}

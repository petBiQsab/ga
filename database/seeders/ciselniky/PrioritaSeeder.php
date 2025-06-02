<?php

namespace Database\Seeders\ciselniky;

use App\Models\Priorita;
use Database\Seeders\DatabaseSeeder;

class PrioritaSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'***'],
        ['value'=>'**'],
        ['value'=>'Bez priority'],

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Priorita::create($value);
        }
    }
}

<?php

namespace Database\Seeders\ciselniky;

use App\Models\Muscow;
use App\Models\RYG;
use Database\Seeders\DatabaseSeeder;

class MuscowSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Must'],
        ['value'=>'Should'],
        ['value'=>'Could'],
        ['value'=>'Won´t'],

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Muscow::create($value);
        }
    }
}

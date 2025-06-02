<?php

namespace Database\Seeders\ciselniky;

use App\Models\Prioritne_oblasti;
use Database\Seeders\DatabaseSeeder;

class PrioritneOblastiSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Efektívne spravované mesto'],
        ['value'=>'Klimaticky odolné a zdravé mesto'],
        ['value'=>'Bezpečná a udržateľná mestská mobilita'],
        ['value'=>'Inkluzívne, starostlivé mesto a prosperujúce štvrte'],

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Prioritne_oblasti::create($value);
        }
    }
}

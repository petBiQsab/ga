<?php

namespace Database\Seeders\ciselniky;

use App\Models\Akceptacia;
use App\Models\Aktivita_Kategoria;
use Database\Seeders\DatabaseSeeder;

class AktivityKategoriaSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Projektová príprava','orderNum'=>'1'],
        ['value'=>'Realizácia','orderNum'=>'2'],
        ['value'=>'Obstarávanie','orderNum'=>'3'],
        ['value'=>'Financovanie','orderNum'=>'4'],
    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Aktivita_Kategoria::create($value);
        }
    }
}

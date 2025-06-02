<?php

namespace Database\Seeders\ciselniky;

use App\Models\Specificke_atributy;
use Database\Seeders\DatabaseSeeder;
use DB;

class SpecifickeAtributySeeder extends DatabaseSeeder
{

    protected $data=[
        ['value'=>'Obstarávanie v projekte'],
        ['value'=>'Legislatívna požiadavka'],
        ['value'=>'Participácia v projekte'],
        ['value'=>'Debarierizácia v projekte'],
    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Specificke_atributy::create($value);
        }
    }

}

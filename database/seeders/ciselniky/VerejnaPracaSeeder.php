<?php

namespace Database\Seeders\ciselniky;

use App\Models\Admin_list;
use App\Models\Verejna_praca;
use Database\Seeders\DatabaseSeeder;

class VerejnaPracaSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Áno'],
        ['value'=>'Nie'],
        ['value'=>'Očakávané'],

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Verejna_praca::create($value);
        }
    }
}

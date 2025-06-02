<?php

namespace Database\Seeders\ciselniky;

use App\Models\Akceptacia;
use Database\Seeders\DatabaseSeeder;

class AkceptaciaSeeder extends DatabaseSeeder
{
    protected $data=[
        ['value'=>'Áno'],
        ['value'=>'Áno, s pripomienkami'],
        ['value'=>'Nie'],
        ['value'=>'Nebol schvaľovaný'],
    ];
   public function run(): void
   {
       foreach ($this->data as $value)
       {
           Akceptacia::create($value);
       }
   }
}

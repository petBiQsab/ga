<?php

namespace Database\Seeders\ciselniky;

use App\Models\Proces_partner_list;
use Database\Seeders\DatabaseSeeder;

class ProcesnyPartnerListSeeder extends DatabaseSeeder
{
    protected $data=[
        ['id_user'=>'5713e22c-3cbd-4bb3-8034-fae52499d07a'],
        ['id_user'=>'0eeb2c8b-8bf2-4742-988e-9260043f0386'],
        ['id_user'=>'6e93db48-3fbb-4335-bf73-7292a000b952'],
        ['id_user'=>'e75122ee-b36c-493f-a82e-4b40923d6631'],
        ['id_user'=>'f04bef52-64c7-494f-8328-7d4af15a44b0'],
        ['id_user'=>'8f12997e-f4cd-40d7-87c8-f954290dd948'],
        ['id_user'=>'04d97afa-a5e4-43ea-a85a-29b6d89c3990'],
        ['id_user'=>'1cc9f5d1-4a3a-46af-82a2-6d1990e653e2'],
        ['id_user'=>'dea1a8d4-f8dc-4a8b-860d-af34d7d86c0c'],
        ['id_user'=>'49fd51ad-ddc9-42ce-bb7d-694236c7c553'],
    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Proces_partner_list::create($value);
        }
    }
}

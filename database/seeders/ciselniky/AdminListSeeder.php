<?php

namespace Database\Seeders\ciselniky;

use App\Models\Admin_list;
use Database\Seeders\DatabaseSeeder;

class AdminListSeeder extends DatabaseSeeder
{
    protected $data=[
        ['id_user'=>'ae5beb5c-ceff-408f-8fb9-3d59643ee6c7'],
        ['id_user'=>'023f8e7f-d2fa-4ba5-9cf6-b69737111005'],
        ['id_user'=>'0e6b0f67-a137-4b27-90f8-7e187f305527'],
        ['id_user'=>'c982fdb6-faee-439a-85b5-9aa8fa233cec'],
        ['id_user'=>'81486c54-e90f-4b80-8567-cf3c20c45000'],
        ['id_user'=>'872f4fff-004e-4feb-afdc-d2a60708a5b8'],
        ['id_user'=>'0ac2b489-f73d-4d09-9851-2cfab75bbe18']

    ];
    public function run(): void
    {
        foreach ($this->data as $value)
        {
            Admin_list::create($value);
        }
    }
}

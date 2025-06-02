<?php

namespace App\Http\Factories;

use App\Http\StoreData\StoreAktivity;
use App\Http\StoreData\StoreAktivityZodpovedni;
use App\Http\StoreData\StoreArrayObjects;
use App\Http\StoreData\StoreArrayStr;
use App\Http\StoreData\StoreArrObjectsRoky;
use App\Http\StoreData\StoreObject;
use App\Http\StoreData\StoreTags;
use App\Http\StoreData\StoreValue;

class StoreDataFactory
{
    public function inicializeStoring($type)
    {
        if ($type=="value")
        {
            return new StoreValue();
        }
        elseif ($type=="ArrObjects")
        {
            return new StoreArrayObjects();
        }
        elseif ($type=="ArrObjectsRoky")
        {
            return new StoreArrObjectsRoky();
        }
        elseif ($type=="Aktivity")
        {
            return new StoreAktivity();
        }
        elseif ($type=="AktivityZodpovedni")
        {
            return new StoreAktivityZodpovedni();
        }elseif ($type=="Tags")
        {
            return new StoreTags();
        }
    }
}

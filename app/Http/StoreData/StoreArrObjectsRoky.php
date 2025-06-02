<?php

namespace App\Http\StoreData;

use App\Http\Interface\FactoryInterface\StorableInterface;


class StoreArrObjectsRoky implements StorableInterface
{
    private bool $isDirty;

    public function __construct()
    {
        $this->isDirty = false;
    }

    private function saveDirty(bool $changeBool): bool
    {
        if ($changeBool === true) {
            $this->isDirty = true;
        }
        return $this->isDirty;
    }
    public function store($model, $attributeArray, $id, $newValue): bool
    {
        foreach ($newValue as $items)
        {
            $model_name=get_class($model);

            if ($model_name!="App\Models\Kvalifikovany_odhad_roky")
            {
                $query=$model::where(['id_pp' => $id,'id'=>$items->id,'rok'=>$items->rok,'typ'=>$attributeArray['typ']])->firstOrNew();
                $query->typ=$attributeArray['typ'];

            }
            else
            {
                $query=$model::where(['id_pp' => $id,'id'=>$items->id,'rok'=>$items->rok])->firstOrNew();
            }

            $query->id_pp=$id;
            $query->rok=$items->rok;
            $query->value=$items->value;
            $this->isDirty = $this->saveDirty($query->isDirty($items->value));
            $query->save();
        }
        return $this->isDirty;
    }
}

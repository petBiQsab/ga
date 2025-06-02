<?php

namespace App\Http\StoreData;

use App\Http\Interface\FactoryInterface\StorableInterface;
use App\Models\Projektove_portfolio;

class StoreValue implements StorableInterface
{
    public function store($model, $attribute, $id, $newValue)
    {

        if ($newValue=="")
        {
            $newValue=null;
        }

        $model_name=get_class($model);

        if ($model_name=="App\Models\Projektove_portfolio")
        {
            $query=$model::where(['id' => $id])->firstOrNew();
            $query->$attribute=$newValue;
            $isDirty = $query->isDirty($attribute);
            $query->save();
            return $isDirty;
        }else
        {
            $query=$model::where(['id_pp' => $id])->firstOrNew();
            $query->id_pp=$id;
            $query->$attribute=$newValue;
            $isDirty = $query->isDirty($attribute);
            $query->save();
            return $isDirty;
        }
    }
}

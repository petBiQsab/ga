<?php

namespace App\Http\StoreData;

use App\Http\Interface\FactoryInterface\StorableInterface;
use App\Models\Projektove_portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StoreAktivityZodpovedni implements StorableInterface
{
    public function store($model, $attribute, $id, $newValue)
    {
        $isDirty = false;

        $arrayID = [];
        foreach ($newValue as $key => $value) {
            $arrayID[] = $value->id;
        }

        $syncResult = $attribute->sync($arrayID);

        // Check if any changes were made during sync
        if (!empty($syncResult['attached']) || !empty($syncResult['detached'])) {
            $isDirty = true;
        }

        return $isDirty;
    }
}


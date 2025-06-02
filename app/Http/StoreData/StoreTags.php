<?php

namespace App\Http\StoreData;

use App\Http\Interface\FactoryInterface\StorableInterface;

class StoreTags implements StorableInterface
{
    private function isDetachedEmptyOrZeros(array $detached): bool
    {
        // Check if the array is empty
        if (empty($detached)) {
            return false;
        }

        // Check if all values in the array are zero
        foreach ($detached as $value) {
            if ($value !== 0) {
                return true;
            }
        }
        return false; // Return true if all values are zero
    }
    public function store($portfolio_model, $tag_object, $id_original, $newValue)
    {
        $isDirty = false;

        $tagIds = [];
        foreach ($newValue as $tagName) {
            $tag = $tag_object::firstOrCreate(['value' => $tagName->value]);
            $tagIds[] = $tag->id;
        }

        $syncResult = $portfolio_model->sync($tagIds);
        // Check if any changes were made during sync
        if (!empty($syncResult['attached']) || $this->isDetachedEmptyOrZeros($syncResult['detached'])) {
            $isDirty = true;
        }
        return $isDirty;
    }

}

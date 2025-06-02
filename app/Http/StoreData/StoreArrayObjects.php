<?php

namespace App\Http\StoreData;

use App\Http\Interface\FactoryInterface\StorableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StoreArrayObjects implements StorableInterface
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
    public function store($model, $attribute, $id, $newValue)
    {

        $arrayID = [];
        foreach ($newValue as $value) {
            $arrayID[] = $value->id;
        }
        // Get the pivot table name and foreign key names dynamically
        $pivotTable = $attribute->getTable();
        $foreignKey1 = $attribute->getForeignPivotKeyName();   // e.g., 'id_pp'
        $foreignKey2 = $attribute->getRelatedPivotKeyName();   // e.g., 'id_phsr'
        // Dynamically determine the model class for the pivot table
        $versionableType = $this->getPivotModelClass($pivotTable);

        // Soft delete entries not in $arrayID
        $recordsToDelete = $attribute->wherePivotNotIn($foreignKey2, $arrayID)
            ->whereNull($pivotTable.'.deleted_at') // Only process rows with NULL deleted_at
            ->get();

        foreach ($recordsToDelete as $record) {
            if ($record->pivot->deleted_at === null) {
                // Only log if the record is not already soft-deleted
                $record->pivot->update(['deleted_at' => Carbon::now()]);
                $this->isDirty = $this->saveDirty(true);

                // Track version for soft-deleted record
                $this->trackVersion([
                    'action' => 'soft-delete',
                    'pivot' => $record->pivot->toArray(),
                ], $versionableType, $id);
            }
        }

        foreach ($arrayID as $newRecordId) {
            // Restore record if it exists but was soft-deleted
            $updatedRows = \DB::table($pivotTable)
                ->where($foreignKey1, $id)
                ->where($foreignKey2, $newRecordId)
                ->whereNotNull('deleted_at')
                ->update([
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ]);

            if ($updatedRows === 0) {
                // If no soft-deleted record was restored, check if it exists
                $existingRecord = \DB::table($pivotTable)
                    ->where($foreignKey1, $id)
                    ->where($foreignKey2, $newRecordId)
                    ->exists();

                if (!$existingRecord) {
                    // Insert new record if it doesn't exist
                    $attribute->attach($newRecordId, [
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'deleted_at' => null
                    ]);

                    // Track version for new record
                    $this->trackVersion([
                        'action' => 'attach',
                        'pivot' => [
                            $foreignKey1 => $id,
                            $foreignKey2 => $newRecordId,
                        ],
                    ], $versionableType, $id);
                    $this->isDirty = $this->saveDirty(true);
                }
            } else {
                // Track version for restored record
                $this->trackVersion([
                    'action' => 'restore',
                    'pivot' => [
                        $foreignKey1 => $id,
                        $foreignKey2 => $newRecordId,
                    ],
                ], $versionableType, $id);
                $this->isDirty = $this->saveDirty(true);
            }
        }
        return $this->isDirty;
    }

    protected function getPivotModelClass(string $tableName): string
    {
        // Define the namespace where your models are located
        $modelNamespace = "App\\Models\\";

        // Scan the models directory to find a matching model
        foreach (glob(app_path('Models/*.php')) as $modelFile) {
            $modelClass = $modelNamespace . basename($modelFile, '.php');

            if (class_exists($modelClass)) {
                $modelInstance = new $modelClass();

                // Check if the model's $table property matches the given table name
                if (property_exists($modelInstance, 'table') && $modelInstance->getTable() === $tableName) {
                    return $modelClass;
                }
            }
        }

        return '"App\\Models\\"UNKNOWN'; // Return null if no matching model is found
    }

    protected function trackVersion(array $data, string $versionableType, int $versionableId)
    {
        // Save version using the versionable package or custom logic
        \DB::table('versions')->insert([
            'versionable_type' => $versionableType, // Dynamically set model name
            'versionable_id' => $versionableId,     // Save project ID
            'user_id' => auth()->id(),              // Adjust as needed
            'contents' => json_encode($data),       // Only save relevant data in `contents`
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

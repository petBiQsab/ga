<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataObjects\DbModels\GroupData as GroupDO;
use App\DataObjects\DbModels\UserData as UserDO;
use App\Exceptions\MultipleRecordsFoundException;
use App\Models\Groups;
use App\Models\User;

class GroupRepository
{
    /**
     * @throws MultipleRecordsFoundException
     */
    public function findOneByGuid(string $guid): ?GroupDO
    {
        $result = Groups::where('objectguid', $guid)->get();

        if ($result->count() > 1) {
            throw new MultipleRecordsFoundException(sprintf('Find multiple groups - guid %s.', $guid));
        }

        return $result->count() === 0 ? null : GroupDO::from($result->first()->getAttributes());
    }

    /**
     * @param array<int, mixed> $criteria
     * @throws MultipleRecordsFoundException
     */
    public function findOneByCriteria(array $criteria): ?GroupDO
    {
        $result = Groups::where($criteria)->get();

        if ($result->count() > 1) {
//            dd($result);
            throw new MultipleRecordsFoundException(sprintf('Find multiple groups - criteria %s.', json_encode($criteria)));
        }

        return $result->count() === 0 ? null : GroupDO::from($result->first()->getAttributes());
    }

    public function save(GroupDO $groupDO): void
    {
        $model = Groups::where('objectguid', $groupDO->objectguid)->first();

        if ($model === null) {
            $model = new Groups();
        }

        $model->fill($groupDO->toArray());
        $model->save();
    }
}

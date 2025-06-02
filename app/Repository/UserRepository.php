<?php

declare(strict_types=1);

namespace App\Repository;

use App\DataObjects\DbModels\UserData as UserDO;
use App\Exceptions\MultipleRecordsFoundException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @throws MultipleRecordsFoundException
     */
    public function findOneByGuid(string $guid): ?UserDO
    {
        $result = User::where('objectguid', $guid)->get();

        if ($result->count() > 1) {
            throw new MultipleRecordsFoundException(sprintf('Find multiple users - guid %s.', $guid));
        }

        return $result->count() === 0 ? null : UserDO::from($result->first()->getAttributes());
    }

    public function save(UserDO $userDO): void
    {
        $model = User::where('objectguid', $userDO->objectguid)->first();

        if ($model === null) {
            $model = new User();
        }

        $model->fill($userDO->toArray());
        $model->save();
    }
}

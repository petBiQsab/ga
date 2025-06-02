<?php

declare(strict_types=1);

namespace App\Services\Synchronizers;

use App\DataObjects\Result\SynchronizationResult;
use App\DataObjects\Sync\FetchedManager;
use App\DataObjects\Sync\FetchedUserGroup;
use App\Models\Managers;
use App\Models\Users_group;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use App\Services\Fetchers\GroupFetcher;
use App\Services\Fetchers\ManagerFetcher;
use App\Services\Fetchers\UserFetcher;
use App\Services\Fetchers\UserGroupFetcher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

readonly class UsersAndGroupsSynchronizer
{
    public function __construct(
        private readonly UserFetcher $userFetcher,
        private readonly GroupFetcher $groupFetcher,
        private readonly UserGroupFetcher $userGroupFetcher,
        private readonly ManagerFetcher $managerFetcher,
        private readonly UserRepository $userRepository,
        private readonly GroupRepository $groupRepository,
    ) {
    }

    public function synchronize(): void
    {
        $logger = Log::channel('sync');
        $userSyncResult = $this->synchronizeUsers();
        $msg = sprintf(
            'User synchronization: %d users, %d same, %d new, %d updated, %d failed',
            $userSyncResult->getFetched(),
            $userSyncResult->getSame(),
            $userSyncResult->getNew(),
            $userSyncResult->getUpdated(),
            $userSyncResult->getFailed(),
        );
        echo $msg . PHP_EOL;
        $logger->info($msg);

        $groupSyncResult = $this->synchronizeGroups();
        $msg = sprintf(
            'Group synchronization: %d groups, %d same, %d new, %d updated, %d failed',
            $groupSyncResult->getFetched(),
            $groupSyncResult->getSame(),
            $groupSyncResult->getNew(),
            $groupSyncResult->getUpdated(),
            $groupSyncResult->getFailed(),
        );
        echo $msg . PHP_EOL;
        $logger->info($msg);

        $userGroupSyncResult = $this->synchronizeUserGroups();
        $msg = sprintf(
            'User group synchronization: %d user groups, %d same, %d new, %d updated, %d failed',
            $userGroupSyncResult->getFetched(),
            $userGroupSyncResult->getSame(),
            $userGroupSyncResult->getNew(),
            $userGroupSyncResult->getUpdated(),
            $userGroupSyncResult->getFailed(),
        );
        echo $msg . PHP_EOL;
        $logger->info($msg);

        $managersSyncResult = $this->synchronizeManagers();
        $msg = sprintf(
            'Managers synchronization: %d managers, %d same, %d new, %d updated, %d failed',
            $managersSyncResult->getFetched(),
            $managersSyncResult->getSame(),
            $managersSyncResult->getNew(),
            $managersSyncResult->getUpdated(),
            $managersSyncResult->getFailed(),
        );
        echo $msg . PHP_EOL;
        $logger->info($msg);
    }

    private function synchronizeUsers(): SynchronizationResult
    {
        $fetchedUsers = $this->userFetcher->fetch();
        $result = new SynchronizationResult(count($fetchedUsers));

        foreach ($fetchedUsers as $fetchedUser) {
            $dbUser = $this->userRepository->findOneByGuid($fetchedUser->objectguid);

            if ($dbUser === null) {
                $result->incNew();
                $user = \App\DataObjects\DbModels\UserData::from($fetchedUser);
                $this->userRepository->save($user);
                continue;
            }

            if ($dbUser instanceof \App\DataObjects\DbModels\UserData && $dbUser->checksum === $fetchedUser->checksum) {
                $result->incSame();
                continue;
            }

            if ($dbUser instanceof \App\DataObjects\DbModels\UserData && $dbUser->checksum !== $fetchedUser->checksum) {
                $result->incUpdated();
                $dbUser->name = $fetchedUser->name;
                $dbUser->sn = $fetchedUser->sn;
                $dbUser->givenName = $fetchedUser->givenName;
                $dbUser->email = $fetchedUser->email;
                $dbUser->department = $fetchedUser->department;
                $dbUser->jobTitle = $fetchedUser->jobTitle;
                $dbUser->activeUser = $fetchedUser->activeUser;
                $dbUser->checksum = $fetchedUser->checksum;
                $this->userRepository->save($dbUser);
            }
        }

        return $result;
    }

    private function synchronizeGroups(): SynchronizationResult
    {
        $fetchedGroups = $this->groupFetcher->fetch();
        $result = new SynchronizationResult(count($fetchedGroups));

        foreach ($fetchedGroups as $fetchedGroup) {
            $dbGroup = $this->groupRepository->findOneByGuid($fetchedGroup->objectguid);

            if ($dbGroup === null) {
                $result->incNew();
                $group = \App\DataObjects\DbModels\GroupData::from($fetchedGroup);
                $this->groupRepository->save($group);
                continue;
            }

            if ($dbGroup instanceof \App\DataObjects\DbModels\GroupData && $dbGroup->checksum === $fetchedGroup->checksum) {
                $result->incSame();
                continue;
            }

            if ($dbGroup instanceof \App\DataObjects\DbModels\GroupData && $dbGroup->checksum !== $fetchedGroup->checksum) {
                $result->incUpdated();
                $dbGroup->cn = $fetchedGroup->cn;
                $dbGroup->skratka = $fetchedGroup->extensionName;
                $dbGroup->typ = $fetchedGroup->type;
                $dbGroup->ico = $fetchedGroup->identificationNumber;
                $dbGroup->checksum = $fetchedGroup->checksum;
                $this->groupRepository->save($dbGroup);
            }
        }

        return $result;
    }

    private function synchronizeUserGroups(): SynchronizationResult
    {
        $fetchedUserGroups = $this->userGroupFetcher->fetch();
        Users_group::truncate();
        $result = new SynchronizationResult(count($fetchedUserGroups));
        Users_group::insert(
            array_map(fn (FetchedUserGroup $ug) => [
                'user_id' => $ug->userGuid,
                'group' => $ug->groupGuid,
                'group_id' => $ug->parentGroupGuid,
                'created_at' => Carbon::now(),
            ], $fetchedUserGroups)
        );
        $result->setNew(count($fetchedUserGroups));

        return $result;
    }

    private function synchronizeManagers(): SynchronizationResult
    {
        $fetchedManagers = $this->managerFetcher->fetch();
        Managers::truncate();
        $result = new SynchronizationResult(count($fetchedManagers));
        Managers::insert(
            array_map(fn (FetchedManager $fm) => [
                'id_user' => $fm->userGuid,
                'id_group' => $fm->groupGuid,
                'created_at' => Carbon::now(),
            ], $fetchedManagers)
        );
        $result->setNew(count($fetchedManagers));

        return $result;
    }
}

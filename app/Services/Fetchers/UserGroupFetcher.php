<?php

declare(strict_types=1);

namespace App\Services\Fetchers;

use App\DataObjects\Sync\FetchedUserGroup;

interface UserGroupFetcher
{
    /**
     * @return array<int, FetchedUserGroup>
     */
    public function fetch(): array;
}
